<?php 
namespace project\controller;

class BackendController extends MainController
{
    /**
    *
    *   Tokens
    *   permet d'hériter des variables propres au parent
    *
    */
    public function __construct() 
    { 	
        parent::__construct();
	}
    /**
    *
    *   Retourne le token généré quand on a créé un nouvel objet FrontendController dans l'index
    *
    */   
    public function getToken() 
    { 
        return $this->token;
    }
    /**
    *
    *   $this permet d'appeler une méthode de sa propre classe
    *   Va chercher la page d'accueil de l'administrateur
    */
	public function adminIndex() 
    {
		$this->displayView('backend/adminIndex'); 
	}
    /**  Va chercher le formulaire de modification d'un chapitre */
	public function editPostForm($postId) 
    {
		$postManager = new \project\model\PostManager();
	    $post = $postManager->getPost($postId);
	    if (!empty($post)) {
			$variables = array(
				'post' => $post,
			);
			$this->displayView('backend/adminPostModifyForm', $variables);
		} else {
			$this->error('Impossible d\'éditer le billet !');
	    }
	}
    /** Ajout d'un chapitre */
	public function addPost($title, $content) 
    {
		$postManager = new \project\model\PostManager();
		$success = $postManager->postPost($title, $content);
		if ($success > 0) {
			header('Location: index.php'); 
	    } else {
			$this->error('Impossible d\'ajouter le billet !');
	    }
	}
    /** 
    *   Modification d'un chapitre   
    *   != $token vérifie que le token de session correspond à celui qui vient du formulaire 
    */
	public function editPost($title, $content, $postId, $token)
    {
		$postManager = new \project\model\PostManager();
		$success = $postManager->editPost($title, $content, $postId);
		if ($_SESSION['token'] != $token) {
            $this->error('Erreur de session');
        }
        
		elseif ($success > 0) {
            header('Location: index.php?action=displayOnePost&chapter_id='. $postId);
		} else {
			$this->error('Impossible d\'éditer le billet !');
		}		    	
	}
    /** Suppression d'un chapitre et de ses commentaires */
	public function deletePost($postId) 
    {
		$postManager = new \project\model\PostManager();
	    $deletePost = $postManager->deletePost($postId);
	 	if ($deletePost > 0) {
	 		header('Location: index.php');
		} else {
			$this->error('Aucun billet n\'a été effacé...');
		}
	}
    /** Gestion des commentaires */
	public function adminComments() 
    {
		$commentManager = new \project\model\CommentManager();
		$comments = $commentManager->getCommentsReported();
		if (!empty($comments)) {
			$variables = array(
				'comments' => $comments,
			);
			$this->displayView('backend/adminComments', $variables);			
		} else {
			$this->error('Il n\'y a aucun commentaire à modérer !');
		}
	}
    /**     
    *   Modification des commentaires
    *   != $token vérifie que le token de session correspond à celui qui vient du formulaire 
    */
	public function editComment($commentId, $comment, $postId, $token) 
    {
        $commentManager = new \project\model\CommentManager();
        $editComment = $commentManager->editComment($commentId, $comment);
        if ($_SESSION['token'] != $token) {
            $this->error('Erreur de session');
        }
        elseif ($editComment > 0) {
            header('Location: index.php?action=displayOnePost&chapter_id='. $postId);
        } else {
            $this->error('Impossible d\'éditer le commentaire...');
        }
    }
    /** Suppression d'un commentaire */  
	public function deleteComment($commentId, $postId) 
    {
		$commentManager = new \project\model\CommentManager();
	    $deleteComment = $commentManager->deleteComment($commentId);
	    if ($deleteComment > 0) {
	        header('Location: index.php?action=displayOnePost&chapter_id='. $postId);
		} else {
			$this->error('Aucun commentaire n\'a été effacé...');
		}
	}
    /** Va chercher la page de modification d'un commentaire */
	public function editCommentForm($commentId) 
    {
		$commentManager = new \project\model\CommentManager();
		$comment = $commentManager->selectComment($commentId);
		if (!empty($comment)) {
			$variables = array(
				'comment' => $comment,
			);
			$this->displayView('backend/adminCommentsForm', $variables);
	    } else {
			$this->error('Ce commentaire n\'existe pas !');
	    }
	}
    /** Deconnexion de la session */
	public function logout() 
    {
	    session_destroy();
		header('Location: index.php');
	}
}
