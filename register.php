<?php
require_once 'a_content.php';
require_once 'page.php';

class register extends a_content
{

    private $reg_ok = true;
    private string $users_filename = "users.dat";

    public function __construct(){
        parent::__construct();
        $this->protected_page = false;
        $this->set_title("Регистрация нового пользователя");
        $this->register();
    }

    private function register(){
        // 1. Проверить логин не пуст и не занят
        // 2. Проверить что пароль по длине >= 6 символам
        // 3. Проверить что пароли совпадают
        // 4. Сохранить пользователя
        if (!isset($_POST['reg'])) return;
        if (
                !isset($_POST['login']) ||
                !isset($_POST['psw']) ||
                !isset($_POST['psw2']) ||
                !isset($_POST['email'])
        ) {
            $this->reg_ok = false;
            return;
        }
        $login = trim($_POST['login']);
        $psw = trim($_POST['psw']);
        $psw2 = trim($_POST['psw2']);
        $email = trim($_POST['email']);
        if (
                mb_strlen($login) == 0 ||
                $this->is_login_exists($login) ||
                mb_strlen($psw) < 6 ||
                strcmp($psw, $psw2) !== 0
        ) {
            $this->reg_ok = false;
            return;
        }
        $f = fopen($this->users_filename, "a");
        $hpsw = password_hash($psw, PASSWORD_DEFAULT);
        fwrite($f, "$login|$hpsw|$email\r\n");
        fclose($f);
    }

    private function is_login_exists($login) : bool{
        $us = file_get_contents($this->users_filename);
        if ($us !== false){
            $usrs = mb_split("\r\n", $us);
            foreach ($usrs as $user){
                $us_info = mb_split('\|', $user, 2);
                if (strcmp($us_info[0], $login) === 0){
                    return true;
                }
            }
        }
        return false;
    }

    public function show_content()
    {
        if (!$this->reg_ok)
            print 'Все плохо!';
        ?>
        <form action="register.php" method="post">
            <input type="hidden" name="reg" value="1">
            <table style="margin: auto;">
                <tr>
                    <td>Ваш логин:</td><td><input type="text" name="login" maxlength="30"></td>
                </tr>
                <tr>
                    <td>Ваш пароль:</td><td><input type="password" name="psw" maxlength="30"></td>
                </tr>
                <tr>
                    <td>Повтор пароля:</td><td><input type="password" name="psw2" maxlength="30"></td>
                </tr>
                <tr>
                    <td>Ваша э-почта:</td><td><input type="email" name="email" maxlength="100"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><input type="submit" value="Зарегистрироваться" style="margin: auto;"></td>
                </tr>
            </table>
        </form>
        <?php
    }
}

new page(new register());