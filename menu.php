<?php

class menu
{
    private $filename = "menu.dat";
    private $menu_items = array();

    public function __construct(){
        if (file_exists($this->filename)){
            $raw_menu_data = file_get_contents($this->filename);
            if ($raw_menu_data !== false){
                $menu_data = mb_split("\r\n", $raw_menu_data);
                foreach ($menu_data as $item){
                    $this->menu_items[] = mb_split(" ", $item, 2);
                }
            }
        }
    }

    public function get_items(){
        return $this->menu_items;
    }
}