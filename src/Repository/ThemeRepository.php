<?php

require_once 'UserRepository.php';

class ThemeRepository
{
    private $conn;

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

        $themes = [];


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $themes[] = new Theme(
                $row['id'],
                $row['name'],
                $row['color'],
                $row['user_id']
            );
        }

        return $themes;
    }

    public function save($theme)
    {
        if ($theme->id) {
            return $this->update($theme);
        }

        return $this->insert($theme);
    }

    private function insert($theme)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO themes (name, color, user_id)
             VALUES (?, ?, ?)"
        );

        if ($stmt->execute([
            $theme->name,
            $theme->color,
            $theme->user_id
        ])) {
            $theme->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    private function update($theme)
    {
        $stmt = $this->conn->prepare(
            "UPDATE themes
             SET name = ?, color = ?
             WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $theme->name,
            $theme->color,
            $theme->id,
            $theme->user_id
        ]);
    }

    public function delete($theme)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM themes WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $theme->id,
            $theme->user_id
        ]);
    }
}
