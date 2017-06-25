<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 5/20/2017
 * Time: 8:55 AM
 */

namespace control;

use model\lang\lang;

class response{

    public static function message($msg, $title, $type = "error", $btn = ""){
        self::result(array('msg' => $msg, 'title' => $title, 'type' => $type, 'btn' => $btn, 'act' => 'message'));
    }

    public static function result($data){
        echo json_encode($data);
        exit;
    }

    public static function showArray($data){
        echo "<br><hr><br>";
        print_r($data);
    }

    public static function breakPoint($data){
        echo "<br><hr><br>";
        print_r($data);
        exit;
    }

    public static function sendResMessage($res){
        if($res){
            self::message(lang::$success, lang::$message, "success");
        }else{
            self::message(lang::$failed, lang::$failed);
        }
    }

    public static function checkGetRes($res){
        if($res){
            self::result($res);
        }else{
            self::message(lang::$not_data_here, lang::$error);
        }
    }

}