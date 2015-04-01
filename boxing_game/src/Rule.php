<?php
class Rule {
    private $from_players_require_attributes = array ();
    private $to_players_require_attributes = array ();
    private $event = '';
    private $do = '';
    public function __construct($event, $from_players_require_attributes, $to_players_require_attributes, $do) {
        $this->event = $event;
        $this->do = $do;
        $this->require_attributes = $require_attributes;
    }
    public function run_by_rule($from_players, $to_players) {
        if (! empty ( $do )) {
            eval ( $do );
        }
    }
    public function check_player($type, $players) {
        if (! is_array ( $players ) && !(players instanceof Player)) {
            return 'bad players.';
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
                if (!($player instanceof Player)) return 'has no-Player object';
                if ($require_attributes == array_intersect ( $require_attributes, $player->get_attribute_names() )) {
                    return true;
                } else {
                    return 'the player unsatisfy requirements.';
                }
            }
        }
        
    }
    // public f
}