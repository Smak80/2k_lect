<?php
class DBHelper{

    private $mi;

    private function __construct(string $user, string $psw){
        $this->mi = new mysqli("localhost", $user, $psw);
        $this->create();
    }

    private static ?DBHelper $instance = null;
    public static function getInstance(string $user, string $psw): DBHelper{
        if (self::$instance === null){
            self::$instance = new DBHelper($user, $psw);
        }
        return self::$instance;
    }

    private function create(){
        try {
            $this->mi->begin_transaction();
            $this->mi->query("CREATE DATABASE IF NOT EXISTS `users`");
            $q = <<<SOMETHING
CREATE TABLE IF NOT EXISTS `users`.`user_data`(
    login varchar(30) not null primary key,
    psw varchar(256) not null,
    email varchar(256)
);
SOMETHING;
            $this->mi->query($q);
            $this->mi->commit();
        } catch (Exception $ex){
            $this->mi->rollback();
            print($ex);
        }
    }

    public function is_user_exists($login): bool
    {
        try{
            $q = "SELECT COUNT(`login`) FROM `users`.`user_data` WHERE `login`='$login'";
            $res = $this->mi->query($q);
            $a_res = $res->fetch_array();
            print_r($a_res);
        } catch (Exception $ex){
            print ($ex);
        }
        return false;
    }

    public function is_authorized(string $login, string $psw) : bool{
        try{
            $q = "SELECT login, psw FROM `users`.`user_data` WHERE login=?";
            $stmt = $this->mi->prepare($q);
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $stmt->bind_result($rl, $rp);
            $stmt->fetch();
            //print("Тестовый результат: ".$rl." ".$rp);
            return password_verify($psw, $rp);
        } catch (Exception $ex){
            return false;
        }
    }

    public function test(){
        $q = "SELECT login FROM `users`.`user_data`";
        $stmt = $this->mi->prepare($q);
        $stmt->execute();
        $stmt->bind_result($login);
        while ($stmt->fetch()) {
            print("Login: {$login}<br>");
        }

    }
}
