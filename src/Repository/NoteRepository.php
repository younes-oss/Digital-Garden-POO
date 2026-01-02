<?php

class NoteRepository
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
            "SELECT n.*, t.name AS theme_name, t.color
             FROM notes n
             JOIN themes t ON n.theme_id = t.id
             WHERE n.user_id = ?
             ORDER BY n.created_at DESC"
        );
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByTheme($themeId, $userId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM notes
             WHERE theme_id = ? AND user_id = ?
             ORDER BY created_at DESC"
        );
        $stmt->execute([$themeId, $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id, $userId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM notes WHERE id = ? AND user_id = ?"
        );
        $stmt->execute([$id, $userId]);

        $note = $stmt->fetch(PDO::FETCH_ASSOC);
        return $note ? $note : null;
    }

    public function create($title, $content, $importance, $themeId, $userId)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO notes (title, content, importance, theme_id, user_id)
             VALUES (?, ?, ?, ?, ?)"
        );

        if ($stmt->execute([
            $title,
            $content,
            $importance,
            $themeId,
            $userId
        ])) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    public function update($id, $title, $content, $importance, $themeId, $userId)
    {
        $stmt = $this->conn->prepare(
            "UPDATE notes
             SET title = ?, content = ?, importance = ?, theme_id = ?
             WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $title,
            $content,
            $importance,
            $themeId,
            $id,
            $userId
        ]);
    }

    public function delete($id, $userId)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM notes WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$id, $userId]);
    }
}
