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

        if ($exists) {
            throw new Exception('Project name already exists');
        }
        return;
    }

    /**
     * Validate project name format
     * 
     * @param string $name Project name
     * @return
     */
    public static function validateProjectName($name)
    {
        if (empty($name)) {
            throw new Exception('Project name is required');
        }

        if (strlen($name) > 100) {
            throw new Exception('Project name must not exceed 100 characters');
        }

        if (strlen($name) < 3) {
            throw new Exception('Project name must be at least 3 characters');
        }

        // Check for valid characters (letters, numbers, spaces, hyphens, underscores)
        if (!preg_match('/^[a-zA-Z0-9\s\-_]+$/', $name)) {
            throw new Exception('Project name can only contain letters, numbers, spaces, hyphens and underscores');
        }

        return;
    }

    /**
     * Validate summary text
     * 
     * @param string $intro Summary text
     * @return 
     */
    public static function validateIntro($intro)
    {
        if (empty($intro)) {
            throw new Exception('Summary is required');
        }

        if (strlen($intro) > 255) {
            throw new Exception('Summary must not exceed 255 characters');
        }

        return;
    }

    /**
     * Validate description text
     * 
     * @param string $description Description text
     * @return 
     */
    public static function validateDescription($description)
    {
        if (empty($description)) {
            throw new Exception('Description is required');
        }

        if (strlen($description) < 20) {
            throw new Exception('Description must be at least 20 characters');
        }

        return;
    }

    /**
     * Validate total slots
     * 
     * @param int $slots Number of slots
     * @return
     */
    public static function validateTotalSlots($slots)
    {
        if (!is_numeric($slots)) {
            throw new Exception('Total slots must be a number');
        }

        $slots = intval($slots);

        if ($slots < 1) {

            throw new Exception('Total slots must be at least 1');
        }

        if ($slots > 50) {
            throw new Exception('Total slots cannot exceed 50');
        }

        return;
    }
}
