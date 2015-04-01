<?php


require_once './Player.php';
require_once './Rule.php';

$game = new Game();
$game->add_player_by_csv_file('./applicants.csv');
class Game{
    private $victory_conditions;
    private $rules = array();
    private $players = array();
    
    public function add_rule($event, $from_players, $to_players, $do){
        $rule = new Rule($event, $require_attributes, $from_players, $to_players, $do);
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
            echo print_r($this->players, true);
        } catch ( Exception $e ) {
            return $e->getMessage ();
            if ($file) {
                $file . close ();
            }
        }
    }
    
    function get_players(){
        return $this->players;
    }
}