<?php 
namespace control;
use model\access\accessCreator;
use model\access\test;
use model\access\test27;

use model\lang\lang;
class controller {
public function __construct(){

        if(!isset($_REQUEST["act"])) {
            header("HTTP/1.0 404 Not Found");
            echo "<h1>404 Not Found</h1>";
            echo "The Action Does Not Exist!";
            exit;
        }
}
public function detect_act(){switch($_SERVER['REQUEST_METHOD']){
            case 'GET'://SELECT
                $this->get();
                break;
            case 'POST'://INSERT
                $this->set();
                break;
            case 'PUT'://UPDATE
                $this->edit();
                break;
            case 'DELETE'://DELETE
                $this->delete();
                break;
            case 'LOCK':// check access
                $this->check();
                break;

            default :
                response::result(lang::$failed);
        }}
public function check(){switch($_REQUEST['act']){
            case 'access_creator':
                if(isset($_REQUEST['user'])&& $_REQUEST['user'] == "peyman"){
                    $access_creator = new accessCreator();
                    $access_creator->run();
                }
                break;
            default:
                response::result(lang::$failed);
        }}
public function set(){switch($_REQUEST['act']){
case 'set_test' :
                $access = new test();
                $access->set();
                break;
case 'set_test27' :
                $access = new test27();
                $access->set();
                break;
default:
                response::result(lang::$failed);
        }}
public function get(){switch($_REQUEST['act']){
case 'get_all_test':
                $access = new test();
                $access->get_all();
                break;
            case 'get_test_by_id':
                $access = new test();
                $access->get_by_id();
                break;
            case 'get_test_create_by':
                $access = new test();
                $access->get_by_created();
                break;
case 'get_all_test27':
                $access = new test27();
                $access->get_all();
                break;
            case 'get_test27_by_id':
                $access = new test27();
                $access->get_by_id();
                break;
            case 'get_test27_create_by':
                $access = new test27();
                $access->get_by_created();
                break;
default:
                response::result(lang::$failed);
        }}
public function delete(){switch($_REQUEST['act']){
case 'delete_test':
                $access = new test();
                $access->delete();
                break;
case 'delete_test27':
                $access = new test27();
                $access->delete();
                break;
default:
                response::result(lang::$failed);
        }}
public function edit(){switch($_REQUEST['act']){
case 'edit_test':
                $access = new test();
                $access->edit();
                break;
case 'edit_test27':
                $access = new test27();
                $access->edit();
                break;
default:
                response::result(lang::$failed);
        }}

} ?>