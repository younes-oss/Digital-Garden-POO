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
            "SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC"
        );
        $stmt->execute([$userId]);

        $notes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $notes[] = new Note(
                $row['id'],
                $row['title'],
                $row['content'],
                $row['importance'],
                $row['user_id'],
                $row['theme_id'],
                $row['created_at']
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
                $row['user_id'],
                $row['theme_id'],
                $row['created_at']
            );
        }

        return $notes;
    }

    public function save($note)
    {
        if ($note->id) {
            return $this->update($note);
        }

        return $this->insert($note);
    }

    private function insert($note)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO notes (title, content, importance, user_id, theme_id)
             VALUES (?, ?, ?, ?, ?)"
        );

        if ($stmt->execute([
            $note->title,
            $note->content,
            $note->importance,
            $note->user_id,
            $note->theme_id
        ])) {
            $note->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    private function update($note)
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
            $note->user_id
        ]);
    }

    public function delete($note)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM notes WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $note->id,
            $note->user_id
        ]);
    }
}
    