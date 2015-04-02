<?php
require_once './Rule.php';
class AllRules{

    private static $_instance;
    private $all_rules = array();
    private $file_name = './rules.csv';

    public static function getInstance(){
        if (!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){
        $this->upload_all_rules_by_csv_file($this->file_name);
    }

    private function __clone(){}

    public function upload_all_rules_by_csv_file($file_name){
        if (! file_exists ( $file_name )) {
            return false;
        }
        try {
            $file = fopen ( $file_name, 'r' );
            $rule_member_name = fgetcsv ( $file );
            while ($row = fgetcsv($file)){
                $rules = new Rule($row[0], $row[1], $row[2], $row[3], $row[4]);
                $this->all_rules[$row[0]] = $rules;
            }
        } catch ( Exception $e ) {
            if ($file) {
                $file . close ();
            }
            return $e->getMessage ();
        }
    }

    public function get_all_rules(){
        return $this->all_rules;
    }

    public function get_rule_by_name($event){
        if (isset($this->all_rules[$event]) && $this->all_rules[$event] instanceof Rule){
            return $this->all_rules[$event];
        }
    }

    public function save_rules_to_csv_file($rules){
        $file_name = $this->file_name;
        if (! file_exists ( $file_name )) {
            return false;
        }
        try {
            $file = fopen ( $file_name, 'a' );
            if (!is_array($rules)){
                $rules = array($rules);
            }
            foreach ($rules as $rule){
                if (!($rule instanceof Rule)) continue;
                $event = $rule->get_event();
                if (isset($this->all_rules[$event])) continue
                $from_player_require_attributes = $rule->get_from_player_require_attributes();
                $to_player_require_attributes = $rule->get_to_player_require_attributes();
                $do = $rule->get_do();
                $cause_status = $rule->get_cause_status();
                if( fputcsv($file, array($event, $from_player_require_attributes, $to_player_require_attributes, $do, $cause_status))){
                    $this->all_rules[$event] = $rule;
                }
            }
        } catch ( Exception $e ) {
            if ($file) {
                $file . close ();
            }
            return $e->getMessage ();
        }
    }
}