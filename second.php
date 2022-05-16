<?php
require_once 'a_content.php';
require_once 'page.php';

class second extends a_content
{
    public function __construct(){
        parent::__construct();
        $this->set_title("Вторая страница");
    }

    public function show_content(){
        print "Привет, {$_SESSION['email']}";
        ?>
        Это контент второй страницы сайта.
        <?php
        for ($i = 0; $i < 45; $i++){
            print '<div>текст</div>';
        }
    }
}

new page(new second());