<?php
class ProjectValidation
{
    /**
     * Check if a project name already exists in the database
     * 
     * @param DatabaseHelper $db Database connection
     * @param string $name Project name to check
     * @return bool True if name exists, false otherwise
     */
    public static function projectNameExists($db, $name)
    {
        $stmt = $db->prepare("SELECT id FROM projects WHERE name = ? LIMIT 1");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        
        return $exists;
    }
}
?>