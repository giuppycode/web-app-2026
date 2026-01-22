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

    /**
     * Validate project name format
     * 
     * @param string $name Project name
     * @return array ['valid' => bool, 'error' => string|null]
     */
    public static function validateProjectName($name)
    {
        if (empty($name)) {
            return ['valid' => false, 'error' => 'Project name is required'];
        }

        if (strlen($name) > 100) {
            return ['valid' => false, 'error' => 'Project name must not exceed 100 characters'];
        }

        if (strlen($name) < 3) {
            return ['valid' => false, 'error' => 'Project name must be at least 3 characters'];
        }

        // Check for valid characters (letters, numbers, spaces, hyphens, underscores)
        if (!preg_match('/^[a-zA-Z0-9\s\-_]+$/', $name)) {
            return ['valid' => false, 'error' => 'Project name can only contain letters, numbers, spaces, hyphens and underscores'];
        }

        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate summary text
     * 
     * @param string $summary Summary text
     * @return array ['valid' => bool, 'error' => string|null]
     */
    public static function validateSummary($summary)
    {
        if (empty($summary)) {
            return ['valid' => false, 'error' => 'Summary is required'];
        }

        if (strlen($summary) > 255) {
            return ['valid' => false, 'error' => 'Summary must not exceed 255 characters'];
        }

        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate description text
     * 
     * @param string $description Description text
     * @return array ['valid' => bool, 'error' => string|null]
     */
    public static function validateDescription($description)
    {
        if (empty($description)) {
            return ['valid' => false, 'error' => 'Description is required'];
        }

        if (strlen($description) < 20) {
            return ['valid' => false, 'error' => 'Description must be at least 20 characters'];
        }

        return ['valid' => true, 'error' => null];
    }

    /**
     * Validate total slots
     * 
     * @param int $slots Number of slots
     * @return array ['valid' => bool, 'error' => string|null]
     */
    public static function validateTotalSlots($slots)
    {
        if (!is_numeric($slots)) {
            return ['valid' => false, 'error' => 'Total slots must be a number'];
        }

        $slots = intval($slots);

        if ($slots < 1) {
            return ['valid' => false, 'error' => 'Total slots must be at least 1'];
        }

        if ($slots > 50) {
            return ['valid' => false, 'error' => 'Total slots cannot exceed 50'];
        }

        return ['valid' => true, 'error' => null];
    }
}
?>