<?php
require_once './Game.php';

function boxing_game(){
    $game = new Game();
    $game->add_player_by_csv_file('./applicants.csv');
    $game->add_rule($event, $from_players_require_attributes, $to_players_require_attributes, $do);
}