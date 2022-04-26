<?php
require_once 'menu.php';
require_once 'a_content.php';

class page
{
    public function __construct(a_content $content){
        $this->start_page();
        print '<div class="wrapper">';
            $this->show_menu();
            print '<div class="main_content">';
                $content->show_content();
            print '</div>';
            $this->show_footer();
        print '</div>';
        $this->finish_page();
    }

    private function start_page(){
        print "<html>";
        print ("<head>");
        ?>
        <meta charset="utf-8">
        <title>Заголовок страницы</title>
        <link rel="stylesheet" type="text/css" href="main.css">
        </head><body>
        <?php
    }

    private function finish_page(){
        ?>
        </body>
        </html>
        <?php
    }

    public function show_menu(){
        $m = new menu();
        $m_items = $m->get_items();
        print '<div class="menu">';
        foreach ($m_items as $item){
            print "<div class='menuitem'><a href='$item[0]'>".$item[1]."</a></div>";
        }
        print '</div>';
    }

    public function show_header(){

    }

    public function show_content(){

    }

    public function show_footer(){
        ?>
        <div class="footer">
            © Маклецов С. В., 2022
        </div>
        <?php
    }
}