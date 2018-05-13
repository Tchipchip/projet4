<?php

session_start();

require('autoloader/autoloader.php');

Autoloader::register();
$frontendController = new \project\controller\FrontendController();
$backendController = new \project\controller\BackendController();

/** 
*   Permet de récupérer le numéro du premier billet de la page à afficher (5 billets/page) 
*   Si le paramètre page n'est pas défini ou n'existe pas, la variable page vaut 1. S'il existe, 
*   lecture de la page
*/
if (!isset($_GET['page']) || $_GET['page'] < 0) { 
    
    $page = 1;
} else {
    $page = htmlspecialchars($_GET['page']); 
}

/** Calcul pour déterminer le premier billet de la page */
$firstPost = 5 * ($page - 1);

/** 
*   Gestion des actions
*   Si "reported" existe, sa valeur est "true"
*/
if (!empty($_GET['action'])) {
    if ($_GET['action'] == 'displayOnePost') {
        if (!empty($_GET['chapter_id']) && $_GET['chapter_id'] > 0) {
            if (!empty($_GET['reported'])) {
                $frontendController->displayOnePost($_GET['chapter_id'], true); 
            } else {
                $frontendController->displayOnePost($_GET['chapter_id']); 
            }
        } else {
            $frontendController->error('L\'identifiant du billet n\'existe pas...');
        }
    
    } elseif ($_GET['action'] == 'addComment') {
        if (!empty($_GET['comment_id']) && $_GET['comment_id'] > 0) {
            if (!empty(trim($_POST['author'])) && !empty(trim($_POST['comment']))) {
                $frontendController->addComment($_GET['comment_id'], $_POST['author'], $_POST['comment']);
            } else {
                $frontendController->error('Tous les champs ne sont pas remplis !');
            }
        } else {
            $frontendController->error('L\'identifiant du billet n\'existe pas...');
        }

/** Si aucune session admin existe, seule l'exécution des actions "front" est permise */
        
    } elseif (empty($_SESSION['user'])) {
        if ($_GET['action'] == 'reportComment') {
            if (!empty($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                $frontendController->report($_GET['comment_id'], $_GET['postId']);
            } else {
                $frontendController->error('L\'identifiant du billet n\'existe pas...');
            }            
/** Connexion administrateur */
        } elseif ($_GET['action'] == 'loginForm') {
            $frontendController->adminForm();
        } elseif ($_GET['action'] == 'login') {
            if (!empty($_POST['password']) AND !empty($_POST['pseudo'])) {
                $frontendController->checkLogin($_POST['password'], $_POST['pseudo']);
            } else {
                $frontendController->error('Tous les champs ne sont pas remplis !');
            }
 /** Affichage d'une page d'erreur si une action administrateur est effecutée sans connexion préalable  */              } else {
            $frontendController->displayView('Connectionerror');
            exit;
        }
/** Une session admin existe, l'exécution des actions "back" est permise */        
    } else {
/** Actions back sur les chapitres */        
        if ($_GET['action'] == 'editPostForm') {
            if (!empty($_GET['chapter_id']) && $_GET['chapter_id'] > 0) {
/** Assigne la variable de session à la valeur du token actuel */                
                $_SESSION['token'] = $backendController->getToken(); 
                $backendController->editPostForm($_GET['chapter_id']);
            } else {
                $backendController->error('L\'identifiant du billet n\'existe pas...');
            }
        } elseif ($_GET['action'] == 'addPost') {
            if (!empty(trim($_POST['title'])) && !empty(trim($_POST['content']))) {
                $backendController->addPost($_POST['title'], $_POST['content']);
            } else {
                $backendController->error('Tous les champs ne sont pas remplis !');
            }
        } elseif ($_GET['action'] == 'editPost') {
            if (!empty($_GET['chapter_id']) && $_GET['chapter_id'] > 0 && !empty(trim($_POST['title'])) && !empty(trim($_POST['content']))) {
                $backendController->editPost($_POST['title'], $_POST['content'], $_GET['chapter_id'], $_POST['token']);
            } else {
                $backendController->error('L\'identifiant du billet n\'existe pas et/ou tous les champs ne sont pas remplis.');
            }
        } elseif ($_GET['action'] == 'deletePost') {
            $backendController->deletePost($_GET['chapter_id']);
 /** Actions back sur les commentaires */
        } elseif ($_GET['action'] == 'displayReportedCommentsAdmin') {
            $backendController->adminComments();
        } elseif ($_GET['action'] == 'editCommentForm') {
            if (!empty($_GET['comment_id']) && $_GET['comment_id'] > 0) {
/** Assigne la variable de session à la valeur du token actuel */                 
                $_SESSION['token'] = $backendController->getToken();
                $backendController->editCommentForm($_GET['comment_id']);
            } else {
                $backendController->error('L\'identifiant du billet n\'existe pas...');
            }            
        } elseif ($_GET['action'] == 'editComment') {
            if (!empty($_POST['id']) && $_POST['id'] > 0 && !empty(trim($_POST['comment'])) && !empty($_POST['id_post']) && $_POST['id_post'] > 0) {
                $backendController->editComment($_POST['id'], $_POST['comment'], $_POST['id_post'], $_POST['token']);
            } else {
                $backendController->error('Tous les champs ne sont pas remplis !');
            }
        } elseif ($_GET['action'] == 'deleteComment') {
            $backendController->deleteComment($_GET['comment_id'], $_GET['id_chapt']);
/** Actions back de l'administrateur */
        } elseif ($_GET['action'] == 'adminIndex') {
            $backendController->adminIndex();
        } elseif ($_GET['action'] == 'logout') {
            $backendController->logout();
        } else {
            $frontendController->displayView('Connectionerror');
        }
    }
} else {
$frontendController->displayAllPost($firstPost);
}
