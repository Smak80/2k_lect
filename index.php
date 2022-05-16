<?php
require_once 'a_content.php';
require_once 'page.php';

class index extends a_content {

    public function __construct(){
        parent::__construct();
        $this->protected_page = false;
        $this->set_title("Основная страница");
    }

    public function show_content(){
        ?>
        Это контент основной страницы сайта.
        Рады вас здесь приветствовать!
        <?php
        for ($i = 0; $i < 45; $i++){
            print '<div>текст</div>';
        }
    }
}

new page(new index());