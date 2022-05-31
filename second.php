<?php
require_once 'a_content.php';
require_once 'page.php';
require_once 'DBHelper.php';

class second extends a_content
{
    public function __construct(){
        parent::__construct();
        $this->set_title("Вторая страница");
    }

    public function show_content(){
        ?>
        Это контент второй страницы сайта.
        <?php
        DBHelper::getInstance("root", "")->test();
    }
}

new page(new second());