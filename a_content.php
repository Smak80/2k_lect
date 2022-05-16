<?php

abstract class a_content
{
    private string $title = "Безымянная страничка";
    protected $protected_page = true;

    public function __construct(){
        session_start();
    }

    public function is_protected(): bool{
        return $this->protected_page;
    }

    public abstract function show_content();

    public function get_title(){
        return $this->title;
    }

    protected function set_title(string $title){
        $this->title = $title;
    }
}