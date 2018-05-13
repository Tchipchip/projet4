<?php
namespace project\model;

class AdminManager extends Manager
{
    /**
    *
    *   Vérification des identifiants de connexion
    *   @param string $password mot de passe
    *   @param string $pseudo pseudo
    *   Password_verify vérifie que les mots de passe (crypté et clair) sont identiques 
    *    
    */ 
    public function checkLogin($password, $pseudo) 
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT user_login, user_pwd FROM user WHERE user_login = ?');
        $req->execute(array($pseudo));
        $admin = $req->fetch();
        if (password_verify($password, $admin['user_pwd'])){ 
            $adminInfo = array(
                'user_login' => $admin['user_login'],   
            );
            return $adminInfo;
    } else {
            return false;
        }
    }
}
