<?php
include_once './AllStatus.php';
class Status{
    private $name = '';
    private $triggering_conditions = '';
    private $require_events = array();

    public function __construct($name, $triggering_conditions, $require_events = array()){
        $this->name = $name;
        $this->triggering_conditions = $triggering_conditions;
        $this->require_events = $require_events;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_triggering_conditions(){
        return $this->triggering_conditions;
    }

    public function get_require_events(){
        return $this->require_events;
    }

    public function check_triggering_conditions($from_players, $to_players, $params){
        if (! empty ( $this->triggering_conditions )) {
            $result = eval ( $this->triggering_conditions );
            if($result === false){
                return 'the '.$this->name.' status triggering conditions has syntax error';
            }
            if (! empty ( $rule ) && $result instanceof Rule) {
                return $rule->run_by_rule ( $from_players, $to_players, $params );
            }
            return $result;
        }
    }
}