<?php

include_once '../config/Database.php';
include_once '../src/Entity/Note.php';

class NoteRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    public function getAllByUser($userId)
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT n.*
                FROM notes n
                LEFT JOIN shared_notes sn ON n.id = sn.note_id
                WHERE n.is_deleted = ?
                AND (n.user_id = ? OR sn.user_id = ?)
");
        $stmt->execute([0,$userId, $userId]);

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

    public function getOne($id)
    {

        $stmt = $this->conn->prepare(
            "SELECT * FROM notes
             where id = ?"
        );
        $stmt->execute([$id]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $note = new Note(
                $row['id'],
                $row['title'],
                $row['content'],
                $row['importance'],
                $row['theme_id']
            );
        }
        return $note;
    }

    public function getUserByNote($noteId)
    {
        $stmt = $this->conn->prepare(
            "SELECT user_id FROM notes
             where id = ?"
        );
        $stmt->execute([$noteId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['user_id'];
    }

    public function save($note, $userId)
    {
        if ($note->id) {
            return $this->update($note, $userId);
        }

        return $this->insert($note, $userId);
    }

    private function insert($note, $userId)
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

    private function update($note, $userId)
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

    public function delete($noteId, $userId)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM notes WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $noteId,
            $userId
        ]);
    }

    public function archive($noteId, $userId)
    {
        $stmt = $this->conn->prepare(
            "UPDATE notes set is_deleted = 1 WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $noteId,
            $userId
        ]);
    }

    public function share($noteId, $user_id, $owner_id)
    {
        $privacyStmt = $this->conn->prepare(
            "UPDATE notes set is_public = 1 WHERE id = ?"
        );

        $privacyStmt->execute([
            $noteId
        ]);

        $pivotStmt = $this->conn->prepare(
            "INSERT into shared_notes(user_id, note_id, owner_id)
                values(?,?,?)"
        );

        return $pivotStmt->execute([
            $user_id,
            $noteId,
            $owner_id
        ]);
    }
}

// $repo = new NoteRepository();
// var_dump($repo->getAllByUser(2));
