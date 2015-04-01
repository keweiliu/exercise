<?php

require_once './Player.php';
require_once './Rule.php';
require_once './Status.php';

class Game{
    private $victory_conditions = '';
    private $rules = array();
    private $players = array();
    private $runing = '';
    private $status = array();
    public $output;
    public function add_rule($event, $from_players_require_attributes, $to_players_require_attributes, $do){
        $rule = new Rule($event, $from_players_require_attributes, $to_players_require_attributes, $do);
        $this->rules[$event] = $rule;
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
    
    public function is_win(){
        if (! empty ( $this->victory_conditions )) {
            if (eval ( $this->victory_conditions ) === false){
                return 'the victory conditions has syntax error';
            }
        }
    }
    
    public function running(){
        if (! empty ( $this->runing )) {
            if (eval ( $this->runing ) === false){
                return 'the running code has syntax error';
            }
        }
    }
    public function get_players(){
        return $this->players;
    }
    
    public function get_rules(){
        return $this->rules;
    }
    public function add_victory_conditions($victory_conditions){
        $this->victory_conditions = $victory_conditions;
    }
    public function add_running_sequence($running){
        $this->runing = $running;
    }
    public function handle_status($status_name){
        if(!in_array($status_name, $this->status)) return 'the status no find';
        $status = $this->status[$status_name];
        $event = $status->get_event();
        $this->rules[$event]->run_by_rule($status->get_from_players(), $status->get_to_players(), array('value' => $status->get_value()));
    }
    public function add_status($name, $value, $event){
        if (!in_array($event, $this->rules)){
            return 'this event inexistence';
        }
        $status = new Status($name, $value, $event);
        $this->status[$name] = $status;
    }
}