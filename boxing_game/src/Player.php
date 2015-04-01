<?php
class Player{
    private $attributes = array();
    private $attribute_names = array();
    
    function get_attributes(){
        return $this->attributes;
    }
    
    function get_attribute_names(){
        return $this->attribute_names;
    }

    function add_attribute($attribute_name, $attribute_value){
        $this->attribute_names[] = $attribute_name;
        $this->attributes[$attribute_name] = $attribute_value;
    }
}
