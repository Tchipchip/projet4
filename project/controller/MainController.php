<?php
namespace project\controller;

class MainController
{	
    /** Tokens */
    protected $token;
    public function __construct() 
    {
        $this->generateToken();
    }
    protected function generateToken() 
    {
        $this->token = bin2hex(rand());
    }
    
    /** Gestion de la pagination */
	public function pagination($nbPost) 
    {
	require('./view/pagination.php');
	}
    /**
    *
    *   Gestion des erreurs
    *   $variables = array, création d'un tableau contenant une variable, afin de pouvoir utiliser celle-ci *   dans un autre contexte, ici, créée par la méthode displayView
    *   $this représente la classe MainController, utilisé ici pour appeler la méthode displayView et ses   *   arguments.
    *
    */    
    public function error($message = 'Erreur') 
    {
		$variables = array( 
			'message' => $message,
		);
		$this->displayView('error', $variables);
	}
    /**
    *
    *   Affichage des vues avec la méthode displayView
    *   extract($variables) : fonction qui sert à aller chercher les variables contenues dans une variable   *   contenant un array et permet de les réutiliser ailleurs
    *
    */   
	public function displayView($view = 'chapterDisplayAll', $variables = array()) 
    {
		extract($variables);
		require('./view/' . $view . '.php');
		if (!empty($_SESSION['user'])) {
			require('./view/backend/adminTemplate.php');
		} else {
			require('./view/frontend/template.php');
		}
	}
    /**
    *
    *   Affichage de tous les chapitres
    *   $postManager : création de l'objet postManager 
    *   $nbPost : appel de la méthode nbPost (qui n'a ici pas d'argument), qui se trouve dans l'objet       *   postManager
    */  
    
	public function displayAllPost($firstPost = 0) 
    {
		$postManager = new \project\model\PostManager(); 
		$nbPost = $postManager->nbPost();
		if ($nbPost > 0) {
			$posts = $postManager->getPosts($firstPost); 
			$variables = array(
				'posts' => $posts,
				'nbPost' => $nbPost,
			);
			$this->displayView('chapterDisplayAll', $variables);
		} else {
    		$this->error('Il n\'y a aucun billet à afficher !');
    	}
	}
    /** Affichage d'un chapitre et de ses commentaires */    
    public function displayOnePost($postId, $reported = false) 
        {
		$postManager = new \project\model\PostManager();
		$commentManager = new \project\model\CommentManager();
		$post = $postManager->getPost($postId);
		if (!empty($post)) {
			$comments = $commentManager->getComments($postId);
			$variables = array(
				'post' => $post,
				'comments' => $comments,
				'reported' => $reported,
			);
			$this->displayView('chapterDisplayOne', $variables);
		} else {
    		$this->error('Il n\'y a aucun billet à afficher !');
		}
	}
    /**
    *
    *   Affichage d'un extrait de chapitre
    *   La méthode getExcerpt affiche un extrait d'un chapitre et donne des valeurs par défaut qui sont     *   modifiables lorsqu'on fait appel à la méthode
    *   > $maxLength si le texte est supérieur à 300 caractères
    *   $string affiche le texte, ddepuis le premier caractère jusqu'au 300ème caractère
    *
    */
    public function getExcerpt($string, $start = 0, $maxLength = 300) 
    {
        if (strlen($string) > $maxLength) { 
            $string = substr($string, $start, $maxLength);
            $string  .= '...';
        }
        return $string;
    }
    /** Ajout d'un commentaire */
    public function addComment($postId, $author, $comment) 
    {
		$commentManager = new \project\model\CommentManager();
		$success = $commentManager->postComment($postId, $author, $comment);
		if ($success != false) {
			header('Location: index.php?action=displayOnePost&chapter_id=' . $postId);
	    } else {
			$this->error('Impossible d\'ajouter le commentaire !');
	    }
	}
}
