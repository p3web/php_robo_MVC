<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 5/20/2017
 * Time: 9:01 AM
 */

namespace control\validation;

class validation{

    private $result = array("is_valid" => true, "cols" => array());

    public function check_set($access){
        $this->result['cols']['id'] = "NULL";
        foreach ($access->getCols() as $col){
            if($col->name != "id"){
                if($col->value == "NULL"){
                    if(isset($_REQUEST[$col->name]) && !empty($_REQUEST[$col->name])){
                        $this->result["cols"][$col->name] = "'".$_REQUEST[$col->name]."'";
                    }else{
                        $this->result['is_valid'] = false;
                        $this->result["cols"][$col->name] = false;
                    }
                }
                else{
                    if($col->type == "timestamp"){$this->result["cols"][$col->name] = $col->value;}
                    else{$this->result["cols"][$col->name] = "'".$col->value."'";}
                }
            }
        }
        return $this->result;
    }

    public function check_edit($access){
        if($this->check_id()){
            $cols = $access->getCols();
            foreach ($cols as $col){
                if(key_exists($col->name, $_REQUEST) && $col->name != "id"){
                    $this->result["cols"][$col->name] = $_REQUEST[$col->name];
                }
            }
        }
        return $this->result;
    }

    public function check_id(){
        if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
            $this->result['is_valid'] = true;
            return true;
        }else{
            $this->result['is_valid'] = false;
            return false;
        }
    }

    public function check($params){
        foreach ($params as $item){
            if(isset($_REQUEST[$item]) && !empty($_REQUEST[$item])){
                $this->result['is_valid'] = true;
                $this->result[$item] = $_REQUEST[$item];
            }else{
                $this->result['is_valid'] = false;
                $this->result[$item] = null;
            }
        }
        return $this->result;
    }
}