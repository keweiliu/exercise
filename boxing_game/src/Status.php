<?php
include_once './AllStatus.php';
class Status{
    private $name = '';
    private $triggering_conditions = '';
    private $cause_events = array();
//    private $values = array();
//    private $from_players = array();
//    private $to_players = array();

    public function __construct($name, $triggering_conditions, $cause_events){
        $this->name = $name;
        $this->triggering_conditions = $triggering_conditions;
        $this->cause_events = $cause_events;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_triggering_conditions(){
        return $this->triggering_conditions;
    }

    public function get_cause_events(){
        return $this->cause_events;
    }

//    public function set_values($values){
//        $this->values = $values;
//    }
//
//    public function get_values(){
//        return $this->values;
//    }
//
//    public function set_from_players($players){
//        $this->from_players = $players;
//    }
//
//    public function get_from_players(){
//        return $this->from_players;
//    }
//
//    public function set_to_players($players){
//        $this->to_players = $players;
//    }
//
//    public function get_to_players(){
//        return $this->to_players;
//    }

    public function check_triggering_conditions($from_players, $to_players, $values){
        if (! empty ( $this->triggering_conditions )) {
            $result = eval ( $this->triggering_conditions );
            if($result === false){
                return 'the '.$this->name.' status triggering conditions has syntax error';
            }
            if($result === true){
                foreach ($cause_events as $cause_event){
                    $rule = AllRules::getInstance()->get_rule_by_name($event);
                    if (!empty($rule) && $rule instanceof Rule){
                        $rule->run_by_rule($from_players, $to_players, $values);
                    }
                }
            }
        }
    }
}