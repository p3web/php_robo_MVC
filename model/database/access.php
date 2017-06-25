<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 5/20/2017
 * Time: 8:10 AM
 */

namespace model\database;

use control\response;
use control\validation\validation;
use model\lang\lang;

class access{

    protected $tbl_name;
    protected $cols = array();
    public    $validation;

    public function __construct($name){
        $this->tbl_name   = $name;
        $this->validation = new validation();
    }

    public function get_all(){
        $res = data::select($this->tbl_name, "*", false, false, false, false, true);
        response::checkGetRes($res);
    }

    public function set(){
        $valid = $this->validation->check_set($this);
        if($valid['is_valid'] == true){
            $cols   = "";
            $values = "";
            $last_name = end(array_keys($valid['cols']));
            foreach ($valid['cols'] as $name => $value){
                $cols .= $name;
                $values .= $value;
                if($name != $last_name){$cols .= " , ";$values .= " , ";}
            }
            $res = data::insert($this->tbl_name, $cols, $values);
            response::sendResMessage($res);
        }else{
            response::message(lang::$invalid_data, lang::$error);
        }
    }

    public function edit(){
        $valid = $this->validation->check_edit($this);
        if($valid['is_valid']){
            if(count($valid['cols']) > 0){
                $last_name = end(array_keys($valid['cols']));
                $params = "";
                foreach ($valid['cols'] as $name => $value){
                    $params .= "`".$name."` = '".$value."'";
                    if($name != $last_name){$params .= " , ";}
                }
//                data::$develop_mode = true;
                $res = data::update($this->tbl_name, $params, "`id` = ".$valid['id']);
                response::sendResMessage($res);
            }else{//empty cols for update
                response::message(lang::$invalid_data, lang::$error);
            }
        }else{
            response::message(lang::$invalid_data, lang::$error);
        }
    }

    public function delete(){
        if($this->validation->check_id()){
            $res = data::delete($this->tbl_name, "`id` = ".$_REQUEST['id']);
            response::sendResMessage($res);
        }else{
            response::message(lang::$invalid_data, lang::$error);
        }
    }

    public function get_by_id(){
        if($this->validation->check_id()){
            $res = data::select($this->tbl_name, "*", "`id` = ".$_REQUEST['id'], false, false, false, true);
            response::checkGetRes($res);
        }else{
            response::message(lang::$invalid_data, lang::$error);
        }
    }

    public function get_by_created(){
        $valid = $this->validation->check(array("createby"));
        if($valid['is_valid']){
            $res = data::select($this->tbl_name, "*", "createBy = ".$valid['createby']);
            response::checkGetRes($res);
        }else{
            response::message(lang::$invalid_data, lang::$error);
        }
    }

    public function get_by_creation_date(){}

    public function to_json(){}

    public function to_sting(){}

    public function json_to_array(){}

}