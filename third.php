<?php
require_once 'a_content.php';
require_once 'page.php';

class third extends a_content
{
    public function __construct(){
        parent::__construct();
        $this->set_title("Третья страница");
    }

    public function show_content(){
        ?>
        Это контент <b>ТРЕТЬЕЙ</b> страницы сайта.
        Рады вас здесь приветствовать!
        <?php
        for ($i = 0; $i < 45; $i++){
            print '<div>текст</div>';
        }
    }
}

new page(new third());