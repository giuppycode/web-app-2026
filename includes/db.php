<?php
// includes/db.php
session_start();

class DatabaseHelper
{
    private $db;
    public function __construct($servername, $username, $password, $dbname, $port = 3306)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            throw new Exception("Connessione fallita: " . $this->db->connect_error);
        }
        $this->db->set_charset("utf8mb4");
    }
    public function query($sql)
    {
        $result = $this->db->query($sql);
        if ($result === false) {
            throw new Exception("Query fallita: " . $this->db->error);
        }
        return $result;
    }
    public function prepare($sql)
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare fallita: " . $this->db->error);
        }
        return $stmt;
    }
    public function close()
    {
        $this->db->close();
    }
}

// Configurazione (Modifica con i tuoi dati)
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'webappdb';

try {
    $db = new DatabaseHelper($host, $user, $pass, $dbname);
} catch (Exception $e) {
    die("Errore di connessione: " . $e->getMessage());
}
?>