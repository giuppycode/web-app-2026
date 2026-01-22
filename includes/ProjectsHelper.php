<?php
class ProjectsHelper
{
    // --- DISCOVERY & SEARCH ---
    public static function getProjects($db, $user_id, $filters = [])
    {
        $searchQuery = $filters['q'] ?? '';
        $filterTag = $filters['tag'] ?? '';
        $filterAvailable = isset($filters['available']);
        $sortOrder = $filters['sort'] ?? 'newest';

        $sql = "SELECT DISTINCT p.id, p.name, p.intro, p.description, p.image_url, p.total_slots, p.occupied_slots, p.created_at,
                (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id AND user_id = ?) as is_starred,
                (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id) as star_count
                FROM projects p 
                LEFT JOIN project_tags pt ON p.id = pt.project_id 
                LEFT JOIN tags t ON pt.tag_id = t.id";

        $whereConditions = [];
        $params = [$user_id];
        $types = "i";

        if ($searchQuery) {
            $whereConditions[] = "(p.name LIKE ? OR p.intro LIKE ? OR t.name LIKE ?)";
            $searchTerm = "%" . $searchQuery . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "sss";
        }

        if ($filterTag) {
            $whereConditions[] = "pt.tag_id = ?";
            $params[] = $filterTag;
            $types .= "i";
        }

        if ($filterAvailable) {
            $whereConditions[] = "p.occupied_slots < p.total_slots";
        }

        if (!empty($whereConditions)) {
            $sql .= " WHERE " . implode(" AND ", $whereConditions);
        }

        if ($sortOrder === 'stars') {
            $sql .= " ORDER BY star_count DESC, p.created_at DESC";
        } else {
            $sql .= " ORDER BY p.created_at DESC";
        }

        $stmt = $db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }

    // --- HOME PAGE ---
    public static function getParticipating($db, $user_id)
    {
        $sql = "SELECT p.*, pm.membership_type, 
                (SELECT COUNT(*) FROM project_members WHERE project_id = p.id) as member_count,
                (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id) as star_count
                FROM projects p 
                JOIN project_members pm ON p.id = pm.project_id 
                WHERE pm.user_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    // Aggiungiamo il parametro $search con default vuoto
    public static function getFavorites($db, $user_id, $filters = [])
    {
        // Recuperiamo i parametri specifici per i preferiti (con suffisso _fav)
        $search = $filters['q_fav'] ?? '';
        $tag = $filters['tag_fav'] ?? '';
        $sort = $filters['sort_fav'] ?? 'newest';
        $available = isset($filters['available_fav']);

        // Query Base
        $sql = "SELECT DISTINCT p.*, 
                (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id) as star_count
                FROM projects p 
                JOIN project_stars ps ON p.id = ps.project_id 
                LEFT JOIN project_tags pt ON p.id = pt.project_id 
                WHERE ps.user_id = ?";

        $params = [$user_id];
        $types = "i";

        // 1. Filtro Ricerca
        if ($search) {
            $sql .= " AND (p.name LIKE ? OR p.intro LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "ss";
        }

        // 2. Filtro Tag
        if ($tag) {
            $sql .= " AND pt.tag_id = ?";
            $params[] = $tag;
            $types .= "i";
        }

        // 3. Filtro Disponibilità
        if ($available) {
            $sql .= " AND p.occupied_slots < p.total_slots";
        }

        // Raggruppiamo per evitare duplicati dovuti al JOIN dei tag
        $sql .= " GROUP BY p.id";

        // 4. Ordinamento
        if ($sort === 'stars') {
            $sql .= " ORDER BY star_count DESC, p.created_at DESC";
        } else {
            $sql .= " ORDER BY p.created_at DESC"; // Default: Più recenti
        }

        $stmt = $db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }

    public static function getLatestNews($db, $project_id)
    {
        $stmt = $db->prepare("SELECT description, DATE_FORMAT(created_at, '%b %d') as date_fmt FROM project_news WHERE project_id = ? ORDER BY created_at DESC LIMIT 3");
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // --- PROJECT PAGE DETAILS ---
    public static function getDetails($db, $project_id)
    {
        $stmt = $db->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getRoles($db, $project_id)
    {
        $stmt = $db->prepare("SELECT * FROM project_roles WHERE project_id = ?");
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        return $stmt->get_result();
    }


    public static function isFounder($db, $project_id, $user_id)
    {
        $stmt = $db->prepare("SELECT membership_type FROM project_members WHERE project_id = ? AND user_id = ? AND membership_type = 'founder'");
        $stmt->bind_param("ii", $project_id, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function isMember($db, $project_id, $user_id)
    {
        $stmt = $db->prepare("SELECT membership_type FROM project_members WHERE project_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $project_id, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getMembers($db, $project_id)
    {
        $stmt = $db->prepare("SELECT u.username, pm.membership_type, pm.user_id, pr.role_name 
                              FROM project_members pm 
                              JOIN users u ON pm.user_id = u.id 
                              LEFT JOIN project_roles pr ON pm.role_id = pr.id
                              WHERE pm.project_id = ?");
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // --- UTILS & ACTIVITY ---
    public static function getAllTags($db)
    {
        $res = $db->query("SELECT * FROM tags ORDER BY name ASC");
        $tags = [];
        while ($row = $res->fetch_assoc()) {
            $tags[] = $row;
        }
        return $tags;
    }

    public static function getAllActivity($db)
    {
        $sql = "SELECT n.*, p.name as project_name, u.username as author 
                FROM project_news n 
                JOIN projects p ON n.project_id = p.id 
                JOIN users u ON n.author_id = u.id 
                ORDER BY n.created_at DESC";
        return $db->query($sql);
    }

    // --- FOUNDER PAGE ---

    // Recupera SOLO i progetti dove l'utente è Founder
    public static function getFoundedProjects($db, $user_id)
    {
        $sql = "SELECT p.* FROM projects p 
                JOIN project_members pm ON p.id = pm.project_id 
                WHERE pm.user_id = ? AND pm.membership_type = 'founder'
                ORDER BY p.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Recupera le ultime news dai progetti fondati E le nuove candidature (per la sezione Notifications)
    public static function getFounderNotifications($db, $user_id)
    {
        // 1. News dai progetti
        $sqlNews = "SELECT n.description, p.name as project_name, n.created_at, 'news' as type, NULL as application_id
                FROM project_news n
                JOIN projects p ON n.project_id = p.id
                JOIN project_members pm ON p.id = pm.project_id
                WHERE pm.user_id = ? AND pm.membership_type = 'founder'";

        // 2. Nuove candidature (Applications)
        // Description formattata: "[Username] wants to join as [Role Name]"
        $sqlApps = "SELECT CONCAT(u.username, ' wants to join as ', pr.role_name) as description, p.name as project_name, pa.created_at, 'application' as type, pa.id as application_id
                FROM project_applications pa
                JOIN projects p ON pa.project_id = p.id
                JOIN users u ON pa.user_id = u.id
                JOIN project_roles pr ON pa.role_id = pr.id
                JOIN project_members pm ON p.id = pm.project_id
                WHERE pm.user_id = ? AND pm.membership_type = 'founder' AND pa.status = 'pending'";

        // Union e ordinamento
        $finalSql = "($sqlNews) UNION ($sqlApps) ORDER BY created_at DESC LIMIT 5";

        $stmt = $db->prepare($finalSql);
        $stmt->bind_param("ii", $user_id, $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Recupera SOLO i progetti dove l'utente è Membro (NON Founder)
    public static function getMemberProjects($db, $user_id)
    {
        $sql = "SELECT p.* FROM projects p 
                JOIN project_members pm ON p.id = pm.project_id 
                WHERE pm.user_id = ? AND pm.membership_type != 'founder'
                ORDER BY p.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>