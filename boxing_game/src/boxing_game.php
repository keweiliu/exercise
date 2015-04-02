<?php
require_once './Game.php';

class BoxingGame{
    public function __construct(){
        $game = new Game();
        $game->add_player_by_csv_file('./applicants.csv');
        $event = 'loss_of_blood';
        $to_players_require_attributes = array('Health');
        $do = '
            if(isset($parameters["value"]){
                $to_players["Health"] -= $parameters["value"];
            }
        ';
        $game->add_rule($event, null, $to_players_require_attributes, $do);
    }
}

function boxing_game(){
    $game = new Game();
    $game->add_player_by_csv_file('./applicants.csv');
    $event = 'loss_of_blood';
    $
    $to_players_require_attributes = array('Health','Damage','Attacks');
    $game->add_rule($event, $from_players_require_attributes, $to_players_require_attributes, $do);
}