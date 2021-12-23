<?php


namespace App\src\DAO;

use App\src\model\Comment;

class CommentDAO extends DAO
{
    public function getComments($articleId)
    {
        $sql = 'SELECT comment.id, comment.user_id, comment.content, comment.created_at, comment.flagged, comment.article_id, user.username FROM comment INNer JOIN user ON comment.user_id=user.id WHERE article_id=:articleId ORDER BY created_at DESC ';
        $result = $this->creatQuery($sql, [
            'articleId' => $articleId]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }

    private function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setUserName($row['username']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['created_at']);
        $comment->setFlagged($row['flagged']);
        $comment->setArticleId($row['article_id']);

        return $comment;
    }

    public function flagOrAllowComment($id, $flagged)
    {
        $sql = 'UPDATE projet4.comment SET flagged=:flagged WHERE id=:id';
        $this->creatQuery($sql, [
            'id' => $id,
            'flagged' => $flagged
        ]);
    }

    public function getFlaggedComments()
    {
        $sql = 'SELECT comment.id, comment.user_id, comment.content, comment.created_at, comment.flagged, comment.article_id, user.username FROM comment INNer JOIN user ON comment.user_id=user.id WHERE flagged=:flagged ORDER BY created_at DESC ';

        $result = $this->creatQuery($sql, [
            'flagged' => 1]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }

    public function addComment($article_id, $user_id, $created_at, $content)
    {
        $sql = 'INSERT INTO projet4.comment(article_id, user_id, created_at, content) VALUES(:article_id, :user_id, :created_at, :content)';
        $this->creatQuery($sql, [
            'article_id' => $article_id,
            'user_id' => $user_id,
            'created_at' => $created_at,
            'content' => $content
        ]);
    }

    public function deleteComment($id)
    {
        $sql = 'DELETE FROM comment WHERE id=:id';
        $this->creatQuery($sql, [
            'id' => $id
        ]);
    }
}