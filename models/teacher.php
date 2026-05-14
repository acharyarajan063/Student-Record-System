<?php

require_once __DIR__ . '/../database/db.php';

class Teacher
{
    private $conn;

    public function __construct()
    {
        $db = new Database();

        $this->conn = $db->connect();
    }

    // Get All Teachers
    public function getAll()
    {
        $sql = "SELECT * FROM teacher";

        return $this->conn->query($sql);
    }

    // Create Teacher
    public function create(
        $name,
        $email,
        $department,
        $dateJoined,
        $isActive
    ){

        $sql = "
        INSERT INTO teacher
        (
            TeacherName,
            Email,
            Department,
            DateJoined,
            IsActive
        )
        VALUES
        (
            ?, ?, ?, ?, ?
        )
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssssi",
            $name,
            $email,
            $department,
            $dateJoined,
            $isActive
        );

        return $stmt->execute();
    }

    // Get Teacher By ID
    public function getById($id)
    {
        $sql = "
        SELECT * FROM teacher
        WHERE TeacherID=?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // Update Teacher
    public function update(
        $id,
        $name,
        $email,
        $department,
        $dateJoined,
        $isActive
    ){

        $sql = "
        UPDATE teacher
        SET
            TeacherName=?,
            Email=?,
            Department=?,
            DateJoined=?,
            IsActive=?
        WHERE TeacherID=?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssssii",
            $name,
            $email,
            $department,
            $dateJoined,
            $isActive,
            $id
        );

        return $stmt->execute();
    }

    // Delete Teacher
    public function delete($id)
    {
        $sql = "
        DELETE FROM teacher
        WHERE TeacherID=?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Search Teacher
    public function search($keyword)
    {
        $sql = "
        SELECT * FROM teacher
        WHERE TeacherName LIKE ?
        OR Email LIKE ?
        OR Department LIKE ?
        ";

        $stmt = $this->conn->prepare($sql);

        $search = "%$keyword%";

        $stmt->bind_param(
            "sss",
            $search,
            $search,
            $search
        );

        $stmt->execute();

        return $stmt->get_result();
    }
}
?>