<?php
namespace project\model;

class PostManager extends Manager
{
    
    /** 
    *
    *   Récupération des cinq derniers chapitres
    *   @param int $firstPost identifiant du premier chapitre
    *   \PDO::PARAM_INT permet d'insérer la variable $firstPost dans la requête sql (en tant que 
    *   nombre entier et pas string)
    *
    */
    public function getPosts($firstPost) 
    { 
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT chapter_id, chapter_title, chapter_content, DATE_FORMAT(chapter_date, \'%d/%m/%Y \') AS chapter_date_fr FROM chapters ORDER BY chapter_date DESC LIMIT ?, 5');
        $req->bindValue(1, $firstPost, \PDO::PARAM_INT); 
        $req->execute();
        return $req;
    }
    
    /**
    *
    *   Récuperation d'un chapitre en fonction de son identifiant
    *   @param int $postId identifiant du chapitre 
    *    
    */
    public function getPost($postId) 
    { 
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT chapter_id, chapter_title, chapter_content, DATE_FORMAT(chapter_date, \'%d/%m/%Y \') AS chapter_date_fr FROM chapters WHERE chapter_id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();
        return $post;
    }
    
    /**
    *
    *   Ajout d'un chapitre
    *   @param string $title titre du chapitre
    *   @param string $content contenu du chapitre
    *   rowCount() permet de compter le nombre de lignes affectées par la dernière requête
    *
    */
    public function postPost($title, $content) 
    { 
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO chapters(chapter_title, chapter_content, chapter_date) VALUES (?, ?, NOW())');
        $req->execute(array($title, $content));
        $affectedLines = $req->rowCount(); 
        return $affectedLines;
    }
    
    /**
 Modification d'un chapitre */

    public function editPost($title, $content, $postId) 
    { 
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE chapters SET chapter_title = ?, chapter_content = ? WHERE chapter_id = ?');
        $req->execute(array($title, $content, $postId));
        $edit = $req->rowCount();
        return $edit;
    }
    
    /** Suppression d'un chapitre et de ses commentaires */
    
    public function deletePost($postId) 
    { 
        $db = $this->dbConnect();
        $comment = $db->prepare('DELETE FROM comments WHERE id_chapt = ?');
        $comment->execute(array($postId));
        $post = $db->prepare('DELETE FROM chapters WHERE chapter_id = ?');
        $post->execute(array($postId));
        $delete = $post->rowCount();
        return $delete;
    }
    
    /** Compte le nombre de chapitres */

    public function nbPost() 
    { 
        $db = $this->dbConnect();
        $req = $db->query('SELECT COUNT(*) FROM chapters');
        $nbPost = $req->fetchColumn();
        return $nbPost;
    }
}
