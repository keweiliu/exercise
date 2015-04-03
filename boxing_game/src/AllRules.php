<?php
require_once './Rule.php';

$all_rules = AllRules::getInstance();
$event = 'die';
$from_players_require_attributes = array("Name");
$to_players_require_attributes = array();
$do = '
    $result["winer"] = $from_player["Name"];
    return $result;
';
$require_status = array();
$rule = new Rule($event, $from_players_require_attributes, $to_players_require_attributes, $do, $require_status);
echo $all_rules->save_rules_to_csv_file($rule);

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
                $event = $row[0];
                $from_players_require_attributes = unserialize($row[1]);
                $to_players_require_attributes = unserialize($row[2]);
                $do = $row[3];
                $require_status = unserialize($row[4]);
                $rules = new Rule($event, $from_players_require_attributes, $to_players_require_attributes, $do, $require_status);
                $this->all_rules[$row[0]] = $rules;
            }
            fclose($file);
        } catch ( Exception $e ) {
            if ($file) {
                fclose($file);
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
                $from_player_require_attributes = serialize($rule->get_from_player_require_attributes());
                $to_player_require_attributes = serialize($rule->get_to_player_require_attributes());
                $do = $rule->get_do();
                $require_status = serialize($rule->get_require_status());
                if( fputcsv($file, array($event, $from_player_require_attributes, $to_player_require_attributes, $do, $require_status))){
                    $this->all_rules[$event] = $rule;
                }
            }
            fclose($file);
            return true;
        } catch ( Exception $e ) {
            if ($file) {
                fclose($file);
            }
            return $e->getMessage ();
        }
    }
}