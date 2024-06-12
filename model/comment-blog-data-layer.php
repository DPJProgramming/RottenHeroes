<?php
class CommentBlogDataLayer
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCommentsByHeroId($heroId, $isBlog = false)
    {
        $stmt = $this->db->prepare('SELECT * FROM comment WHERE heroId = :heroId AND isBlog = :isBlog');
        $stmt->bindParam(':heroId', $heroId, PDO::PARAM_INT);
        $stmt->bindParam(':isBlog', $isBlog, PDO::PARAM_BOOL);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentsByUserId($userId)
    {
        $stmt = $this->db->prepare('SELECT * FROM comment WHERE userId = :userId ORDER BY created_at DESC LIMIT 5');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createComment($commentData)
    {
        $stmt = $this->db->prepare("INSERT INTO comment (body, userId, userName, heroId, rating, isBlog, created_at) 
                        VALUES (:body, :userId, :userName, :heroId, :rating, :isBlog, NOW())");
        $stmt->bindParam(':body', $commentData['body'], PDO::PARAM_STR);
        $stmt->bindParam(':userId', $commentData['userId'], PDO::PARAM_INT);
        $stmt->bindParam(':userName', $commentData['userName'], PDO::PARAM_STR);
        $stmt->bindParam(':heroId', $commentData['heroId'], PDO::PARAM_INT);
        $stmt->bindParam(':rating', $commentData['rating'], PDO::PARAM_INT);
        $stmt->bindParam(':isBlog', $commentData['isBlog'], PDO::PARAM_BOOL);
        $stmt->execute();
    }
  //Allows for the deletion of comments
    public function deleteComment($commentId, $userId)
    {
        $stmt = $this->db->prepare('DELETE FROM comment WHERE commentId = :commentId AND userId = :userId');
        $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateComment($commentData)
    {
        $stmt = $this->db->prepare("UPDATE comment SET body = :body WHERE commentId = :commentId");
        $stmt->bindParam(':body', $commentData['body'], PDO::PARAM_STR);
        $stmt->bindParam(':commentId', $commentData['comment_id'], PDO::PARAM_INT);
        $stmt->execute();
    }

}

?>