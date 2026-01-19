<?php
class UserHelper
{
    // Recupera dati anagrafici
    public static function getData($db, $user_id)
    {
        $stmt = $db->prepare("SELECT username, email, biography FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Calcola le statistiche per la dashboard
    public static function getStats($db, $user_id)
    {
        // Founded
        $founded = $db->query("SELECT COUNT(*) as c FROM project_members WHERE user_id = $user_id AND membership_type = 'founder'")->fetch_assoc()['c'];

        // Starred
        $starred = $db->query("SELECT COUNT(*) as c FROM project_stars WHERE user_id = $user_id")->fetch_assoc()['c'];

        // Member
        $member = $db->query("SELECT COUNT(*) as c FROM project_members WHERE user_id = $user_id AND membership_type = 'member'")->fetch_assoc()['c'];

        // Updates recenti
        $updates = $db->query("SELECT COUNT(*) as c FROM project_news WHERE author_id = $user_id AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch_assoc()['c'];

        return [
            'founded' => $founded,
            'starred' => $starred,
            'member' => $member,
            'updates' => $updates
        ];
    }
}
?>