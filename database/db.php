<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "student_record_system";

    public function connect() {
        return new mysqli($this->host, $this->user, $this->pass, $this->db);
    }
}
?>