<?php
namespace project\model;

class CommentManager extends Manager
{
    /**
    *
    *   Récuperation des commentaires en fonction de l'identifiant du chapitre
    *   @param int $postId identifiant du chapitre 
    *    
    */    
    public function getComments($postId)
    {
		$db = $this->dbConnect();
	    $comments = $db->prepare('SELECT comment_id, id_chapt, comment_author, comment_content, comment_report, DATE_FORMAT(comment_date, \'%d/%m/%Y \') AS comment_date_fr FROM comments WHERE id_chapt = ? ORDER BY comment_date DESC');
	    $comments->execute(array($postId));
    	return $comments;
	}
    /**
    *
    *   Ajout de commentaires 
    *   @param string $author auteur du commentaire
    *   @param string $comment commentaire
    *    
    */  
	public function postComment($postId, $author, $comment)
    {
	    $db = $this->dbConnect();
	    $comments = $db->prepare('INSERT INTO comments(id_chapt, comment_author, comment_content, comment_date) VALUES(?, ?, ?, NOW())');
	    $affectedLines = $comments->execute(array($postId, $author, $comment));
   		return $affectedLines;
	}
    /**
    *
    *   Visualisation d'un commentaire
    *   @param int $commentId identifiant de commentaire
    *    
    */ 
	public function selectComment($commentId)
	{
		$db = $this->dbConnect();
		$comment = $db->prepare('SELECT comment_id, comment_content, id_chapt FROM comments WHERE comment_id = ?');
		$comment->execute(array($commentId));
		$comment = $comment->fetch();
		return $comment;
	}
    /**
    *
    *   Modification d'un  commentaire
    *   @param string $comment commentaire
    *    
    */ 
	public function editComment($commentId, $comment)
	{
	    $db = $this->dbConnect();
	    $req = $db->prepare('UPDATE comments SET comment_content = ?, comment_report = 0 WHERE comment_id = ?');
	    $req->execute(array($comment, $commentId));
        $edit = $req->rowCount();
        return $edit;
	}
    /** Signalement d'un commentaire */
	public function reportComment($commentId)
	{
	    $db = $this->dbConnect();
		$req = $db->prepare('UPDATE comments SET comment_report = 1 WHERE comment_id = ?');
		$req->execute(array($commentId));
		$report = $req->rowCount(); 
		return $report;
	}
    /** Récupération des commentaires signalés associés à un identifiant de chapitre */
	    public function getCommentsReported()
    {
		$db = $this->dbConnect();
	    $comments = $db->query('SELECT comments.comment_id, chapters.chapter_title, comments.id_chapt, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y \') AS comment_date_fr FROM comments INNER JOIN chapters ON chapters.chapter_id = comments.id_chapt WHERE comment_report = 1 ORDER BY comment_date DESC');
    	return $comments;            
	}
     /** Suppression d'un commentaire */
    public function deleteComment($commentId) 
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE comment_id = ?');
        $req->execute(array($commentId));
        $delete = $req->rowCount();
        return $delete;
    }
}