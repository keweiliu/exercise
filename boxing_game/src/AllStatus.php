<?php
require_once './Status.php';

$all_status = AllStatus::getInstance();
$name = 'be_injured';
$triggering_conditions = '
    $to_player["Health"] -= $values["value"];
    if($to_player["Health"]<=0){
        return true;
    }
';
$cause_event = array('die');
$status = new Status($name, $triggering_conditions, $cause_event);
echo $all_status->save_status_to_csv_file($status);

class AllStatus{

    private static $_instance;
    private $all_status = array();
    private $file_name = './status.csv';

    public static function getInstance(){
        if (!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){
        $this->upload_all_status_by_csv_file($this->file_name);
    }

    private function __clone(){}

    public function upload_all_status_by_csv_file($file_name){
        if (! file_exists ( $file_name )) {
            return false;
        }
        try {
            $file = fopen ( $file_name, 'r' );
            $status_member_name = fgetcsv ( $file );
            while ($row = fgetcsv($file)){
                $name = $row[0];
                $triggering_conditions = $row[1];
                $cause_event = unserialize($row[2]);
                $status = new Status($row[0], $row[1], $row[2]);
                $this->all_status[$name] = $status;
            }
        } catch ( Exception $e ) {
            if ($file) {
                $file . close ();
            }
            return $e->getMessage ();
        }
    }

    public function get_all_status(){
        return $this->all_status;
    }

    public function get_status_by_name($name){
        if (isset($this->$all_status[$name]) && $this->all_status[$name] instanceof Status){
            return $this->$all_status[$name];
        }
    }

    public function save_status_to_csv_file($status){
        $file_name = $this->file_name;
        if (! file_exists ( $file_name )) {
            return false;
        }
        try {
            $file = fopen ( $file_name, 'a' );
            if (!is_array($status)){
                $status = array($status);
            }
            foreach ($status as $one_status){
                if (!($one_status instanceof Status)) continue;
                $name = $one_status->get_name();
                if (isset($this->all_status[$name])) continue;
                $triggering_conditions = $one_status->get_triggering_conditions();
                $cause_events = serialize($one_status->get_cause_events());
                if(fputcsv($file, array($name, $triggering_conditions, $cause_events))){
                    $this->all_status[$name] = $one_status;
                }
            }
            return true;
        } catch ( Exception $e ) {
            if ($file) {
                $file . close ();
            }
            return $e->getMessage ();
        }
    }
}