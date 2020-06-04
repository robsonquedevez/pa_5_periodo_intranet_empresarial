<?php

namespace app;

use App\Model;
use App\Sql;

class User extends Model {

    const SESSION = "User";

    public static function login($login, $password){

        $sql = new Sql();
        $conn = $sql->getConnection();
        
        $results = $sql->select("SELECT * FROM tb_usuarios WHERE usuario = :LOGIN ", array(
            ":LOGIN"=>$login
        ));

        if (count($results) === 0) {
            throw new \Exception("Senha Invalida");
        }

        $data = $results[0];

        if (password_verify($password, $data['senha']) === true) {

            $user = new User();

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getValues();

            return $user;

        }
        else{
            throw new \Exception("Senha Invalida");
        }

    }

    public static function verifyLogin(){

        if (
            !isset($_SESSION[User::SESSION])
            ||
            !($_SESSION[User::SESSION])
            ||
            !(int)$_SESSION[User::SESSION]["id"] > 0
        ){
            header("Location: /login");
            exit;
        }

    }

    public static function logout(){

        $_SESSION[User::SESSION] = NULL;

    }

}

?>