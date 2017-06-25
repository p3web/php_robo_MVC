<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 5/20/17 AD
 * Time: 21:11
 */


//_________ init include file
function __autoload($class_name){
    $path = str_replace("\\", "/",str_replace("_", "/", $class_name).".php");
    require_once $path;
}
$controller = new control\controller();
$controller->detect_act();
