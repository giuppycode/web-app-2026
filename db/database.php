<?php
class DatabaseHelper
{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port = 3306)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);

        if ($this->db->connect_error) {
            throw new Exception("Connection failed: " . $this->db->connect_error);
        }

        $this->db->set_charset("utf8mb4");
    }

    public function query($sql)
    {
        $result = $this->db->query($sql);
        if ($result === false) {
            throw new Exception("Query failed: " . $this->db->error);
        }
        return $result;
    }

    public function close()
    {
        $this->db->close();
    }

    public function prepare($sql)
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->error);
        }
        return $stmt;
    }
}
?>