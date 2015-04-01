<?php
class Status{
    private $name = '';
    private $value = '';
    private $event = '';
    private $from_players;
    private $to_players;
    public function __construct($name, $value, $event){
        $this->name = $name;
        $this->value = $value;
        $this->event = $event;
    }
    public function get_event(){
        return $this->event;
    }
    public function get_value(){
        return $this->value;
    }
    public function set_from_players($players){
        $this->from_players = $players;
    }
    public function set_to_players($players){
        $this->to_players = $players;
    }
    public function get_from_players(){
        return $this->from_players;
    }
    public function get_to_players(){
        return $this->to_players;
    }
}