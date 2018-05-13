<?php 

namespace project\controller;


class FrontendController extends MainController
{
    /** Signalement d'un commentaire */
	public function report($commentId, $postId) 
    {
		$commentManager = new \project\model\CommentManager();
		$report = $commentManager->reportComment($commentId);
		if ($report > 0) {
			header('Location: index.php?action=displayOnePost&reported=true&chapter_id=' . $postId);
		} else {
    		$this->error('Ce message a déjà été signalé et va être modéré prochainement, merci !');
		}
	}
    /** 
    *    Connexion administrateur
    *    $this représente ici la classe FrontendController et permet d'appeler une méthode de sa classe
    */
	public function adminForm() 
    {
		$this->displayView('frontend/adminForm');
	}
    /** 
    *   Vérification des identifiants de connexion
    *   is_array($adminInfo) vérifie que l'on est en présence d'un tableau, car la méthode checkLogin
    *   retourne soit un tableau (dans la variabe $adminInfo), soit false.
    *   $_SESSION['user_login'] = $adminInfo['pseudo'] va chercher l'info pseudo contenu dans le tableau
    *   contenu dans la variable adminInfo lorsque statut est true
    */
	public function checkLogin($password, $pseudo) 
    {
		$adminManager = new \project\model\AdminManager();
		$adminInfo = $adminManager->checkLogin($_POST['password'], $_POST['pseudo']);
        if (is_array($adminInfo)) { 
            $_SESSION['user'] = true;
            $_SESSION['user_login'] = $adminInfo['pseudo']; 
            $_SESSION['user_pwd'] = $adminInfo['user_pwd'];
        	header('Location: index.php?action=adminIndex');
        } else {
    		$this->error('Votre pseudo ou votre mot de passe sont incorrects !');
        }
	}
}
