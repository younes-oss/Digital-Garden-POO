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
            "SELECT * FROM notes WHERE user_id = ? and is_deleted = ? ORDER BY created_at DESC"
        );
        $stmt->execute([$userId,0]);

        $notes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $notes[] = new Note(
                $row['id'],
                $row['title'],
                $row['content'],
                $row['importance'],
                $row['theme_id']
            );
        }

        return $notes;
    }

    public function getByTheme($themeId, $userId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM notes
             WHERE theme_id = ? AND user_id = ?
             ORDER BY created_at DESC"
        );
        $stmt->execute([$themeId, $userId]);

        $notes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $notes[] = new Note(
                $row['id'],
                $row['title'],
                $row['content'],
                $row['importance'],
                $row['theme_id']
            );
        }

        return $notes;
    }

    public function save($note,$userId)
    {
        if ($note->id) {
            return $this->update($note,$userId);
        }

        return $this->insert($note,$userId);
    }

    private function insert($note,$userId)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO notes (title, content, importance, theme_id, user_id)
             VALUES (?, ?, ?, ?, ?)"
        );

        if ($stmt->execute([
            $note->title,
            $note->content,
            $note->importance,
            $note->theme_id,
            $userId
        ])) {
            $note->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    private function update($note,$userId)
    {
        $stmt = $this->conn->prepare(
            "UPDATE notes
             SET title = ?, content = ?, importance = ?, theme_id = ?
             WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $note->title,
            $note->content,
            $note->importance,
            $note->theme_id,
            $note->id,
            $userId
        ]);
    }

    public function delete($noteId , $userId)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM notes WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $noteId,
            $userId
        ]);
    }

    public function archive($noteId , $userId)
    {
        $stmt = $this->conn->prepare(
            "UPDATE notes set is_deleted = 1 WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $noteId,
            $userId
        ]);
    }
}
    