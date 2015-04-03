<?php

require_once './Player.php';
require_once './Rule.php';
require_once './Status.php';
require_once './AllRules.php';
require_once './AllStatus.php';

class Game{

    private $players = array();
    private $rules = array();
    private $status = array();
    private $runing = '';
    private $victory_conditions = '';
    private $output;

    public function __construct($victory_conditions, $running){
        $this->victory_conditions = $victory_conditions;
        $this->runing = $running;
    }

    public function add_player_by_csv_file($file_name){
        if (! file_exists ( $file_name )) {
            return false;
        }
        try {
            $file = fopen ( $file_name, 'r' );
            $attribute_names = fgetcsv ( $file );
            $count = 0;
            while ($row = fgetcsv($file)){
                $player = new Player();
                foreach ($row as $key => $value){
                    $player->add_attribute($attribute_names[$key], $value);
                }
                $this->players[] = $player;
                $count++;
            }
        } catch ( Exception $e ) {
            if ($file) {
                $file . close ();
            }
            return $e->getMessage ();
        }
    }

    public function add_rule($event){
        $rule = AllRules::getInstance()->get_rule_by_name($event);
        if(!empty($rule)){
            $status = $rule->get_require_status();
            foreach ($status as $one_status){
                $this->add_status($one_status);
            }
            $this->rules[$event] = $rule;
        }
    }

    public function add_status($name){
        $status = AllStatus::getInstance()->get_status_by_name($name);
        if(!empty($status)){
            $events = $status->get_require_events();
            foreach ($events as $event){
                $this->add_rule($event);
            }
            $this->status[$name] = $status;
        }
    }

    public function running(){
        if (! empty ( $this->runing )) {
            if (eval ( $this->runing ) === false){
                return 'the running code has syntax error';
            }
        }
    }

    public function is_win(){
        if (! empty ( $this->victory_conditions )) {
            $result = eval ( $this->victory_conditions );
            if ( $result === false){
                return 'the victory conditions has syntax error';
            }
            if ( $result === true ){
                $this->output;
            }
        }
    }

    public function get_players(){
        return $this->players;
    }

    public function get_rules(){
        return $this->rules;
    }

    public function get_rule($rule_name){
        if (isset($this->all_rules[$event]) && $this->all_rules[$event] instanceof Rule){
            return $this->all_rules[$event];
        }
    }

    public function output(){
        echo print_r($this->output, true);
    }
}