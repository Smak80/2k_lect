<?php
require_once 'a_content.php';
require_once 'page.php';

class login extends a_content
{
    private $log_ok = true;
    private string $users_filename = "users.dat";

    public function __construct(){
        parent::__construct();
        $this->protected_page = false;
        $this->set_title("Авторизация пользователя");
        if ($this->exiting()){
            unset($_SESSION['auth']);
        } else {
            $this->login();
        }
    }

    private function exiting() : bool{
        return (isset($_GET['exit']) && $_GET['exit']==1);
    }

    private function login(){
        if (!isset($_POST['login']) &&
            !isset($_POST['psw'])) return;
        if (!isset($_POST['login']) ||
            !isset($_POST['psw']) ||
            mb_strlen($_POST['login']) < 1 ||
            mb_strlen($_POST['psw']) < 6 ||
            !$this->is_authorized($_POST['login'], $_POST['psw'])
        ) {
            $this->log_ok = false;
        }
        $_SESSION['auth'] = 1;
    }

    private function is_authorized($login, $psw) : bool{
        $us = file_get_contents($this->users_filename);
        if ($us !== false){
            $usrs = mb_split("\r\n", $us);
            foreach ($usrs as $user){
                $us_info = mb_split('\|', $user);
                if (strcmp($us_info[0], $login) === 0){
                    $res = password_verify($psw, $us_info[1]);
                    if ($res) $_SESSION['email'] = $us_info[2];
                    return $res;
                }
            }
        }
        return false;
    }

    public function show_content()
    {
        if (!$this->log_ok)
            print 'Все плохо!';
        ?>
        <form action="login.php" method="post">
            <table style="margin: auto;">
                <tr>
                    <td>Ваш логин:</td><td><input type="text" name="login" maxlength="30"></td>
                </tr>
                <tr>
                    <td>Ваш пароль:</td><td><input type="password" name="psw" maxlength="30"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><input type="submit" value="Войти" style="margin: auto;"></td>
                </tr>
            </table>
        </form>
        <?php
    }
}

new page(new login());