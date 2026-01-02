<?php

class ThemeRepository
{
    private PDO $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllByUser($userId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM themes WHERE user_id = ? ORDER BY id DESC"
        );
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id,$userId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM themes WHERE id = ? AND user_id = ?"
        );
        $stmt->execute([$id, $userId]);

        $theme = $stmt->fetch(PDO::FETCH_ASSOC);
        return $theme ?: null;
    }

    public function create($name, $color, $userId)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO themes (name, color, user_id) VALUES (?, ?, ?)"
        );

        if ($stmt->execute([$name, $color, $userId])) {
            return (int)$this->conn->lastInsertId();
        }

        return false;
    }

    public function update($id, $name,$color, $userId)
    {
        $stmt = $this->conn->prepare(
            "UPDATE themes SET name = ?, color = ?
             WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$name, $color, $id, $userId]);
    }

    public function delete($id, $userId)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM themes WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$id, $userId]);
    }
}
