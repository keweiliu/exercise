<?php
class Rule {
    private $from_players_require_attributes = array ();
    private $to_players_require_attributes = array ();
    private $event = '';
    private $do = '';
    private $parameters = array();
    private $status = array();
    public $output;
    public function __construct($event, $from_players_require_attributes, $to_players_require_attributes, $do) {
        $this->event = $event;
        $this->do = $do;
        $this->from_players_require_attributes = $from_players_require_attributes;
        $this->to_players_require_attributes = $to_players_require_attributes;
        $this->parameters = $parameters;
    }
    public function run_by_rule($from_players, $to_players, $parameters = array()) {
        $from_check = $this->check_player('from', $from_players);
        if ($from_check !== true) return $from_check;
        $to_check = $this->check_player('to', $to_players);
        if ($to_check !== true) return $to_check;
        if (! empty ( $this->do )) {
            if(eval ( $this->do ) === false){
                return 'the '.$this->event.' rule has syntax error';
            }
        }
    }
    public function check_player($type, $players) {
        if (! is_array ( $players ) && !(players instanceof Player)) {
            return 'bad '.$type.' players.';
        }
        switch ($type) {
            case 'from' :
                $require_attributes = $this->from_players_require_attributes;
                break;
            case 'to' :
                $require_attributes = $this->to_players_require_attributes;
                break;
            default:
                return 'unknow type';
        }
        if (is_array ( $players )){
            foreach ( $players as $player ) {
                if (!($player instanceof Player)) return 'the '.$type.' player is no-Player object';
                if ($require_attributes == array_intersect ( $require_attributes, $player->get_attribute_names() )) {
                    return true;
                } else {
                    return 'the '.$type.' player  '.$type.' unsatisfy requirements.';
                }
            }
        }else {
            if ($require_attributes == array_intersect ( $require_attributes, $players->get_attribute_names() )) {
                return true;
            } else {
                return 'the '.$type.' player unsatisfy requirements.';
            }
        }
    }
    public function get_status(){
        return $this->status;
    }
}