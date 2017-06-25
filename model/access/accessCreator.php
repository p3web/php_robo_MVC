<?php
/**
 * Created by PhpStorm.
 * User: amir's dell
 * Date: 5/20/2017
 * Time: 8:59 AM
 */
namespace model\access;

use control\classMaker;
use model\database\data;

class accessCreator{

    public function run(){
        $tables = data::select("information_schema.tables","table_name","table_schema='".data::$database."'", false, false, false, true);
        $detect = 'switch($_SERVER[\'REQUEST_METHOD\']){
            case \'GET\'://SELECT
                $this->get();
                break;
            case \'POST\'://INSERT
                $this->set();
                break;
            case \'PUT\'://UPDATE
                $this->edit();
                break;
            case \'DELETE\'://DELETE
                $this->delete();
                break;
            case \'LOCK\':// check access
                $this->check();
                break;

            default :
                response::result(lang::$failed);
        }';
        $construct = '
        if(!isset($_REQUEST["act"])) {
            header("HTTP/1.0 404 Not Found");
            echo "<h1>404 Not Found</h1>";
            echo "The Action Does Not Exist!";
            exit;
        }';
        $use    = '';
        $get    = 'switch($_REQUEST[\'act\']){'."\n";
        $set    = 'switch($_REQUEST[\'act\']){'."\n";
        $edit   = 'switch($_REQUEST[\'act\']){'."\n";
        $delete = 'switch($_REQUEST[\'act\']){'."\n";
        $check  = 'switch($_REQUEST[\'act\']){
            case \'access_creator\':
                if(isset($_REQUEST[\'user\'])&& $_REQUEST[\'user\'] == "peyman"){
                    $access_creator = new accessCreator();
                    $access_creator->run();
                }
                break;
            default:
                response::result(lang::$failed);
        }';
        foreach ($tables as $value){
            $table = $value['table_name'];
            $class = new classMaker($table, "access");
            $class->setNamespace("namespace model\\access;");
            $class->setConstruct("parent::__construct(\"$table\");");
            $class->setUse("use model\\database\\access;");
            $class->setUse("use model\\database\\param;");
            $class->setFunction("public", "getCols", 'return $this->cols;');
            $use .= 'use model\access\\'.$table.';'."\n";
            $set .= 'case \'set_'.$table.'\' :
                $access = new '.$table.'();
                $access->set();
                break;'."\n";
            $edit .= 'case \'edit_'.$table.'\':
                $access = new '.$table.'();
                $access->edit();
                break;'."\n";
            $delete .= 'case \'delete_'.$table.'\':
                $access = new '.$table.'();
                $access->delete();
                break;'."\n";
            $get .= 'case \'get_all_'.$table.'\':
                $access = new '.$table.'();
                $access->get_all();
                break;
            case \'get_'.$table.'_by_id\':
                $access = new '.$table.'();
                $access->get_by_id();
                break;
            case \'get_'.$table.'_create_by\':
                $access = new '.$table.'();
                $access->get_by_created();
                break;'."\n";
            $class->create("model/access/$table.php");
        }
            $columns = data::select("INFORMATION_SCHEMA.COLUMNS", "COLUMN_NAME, COLUMN_TYPE, COLUMN_DEFAULT", "table_name = '".$value['table_name']."' and table_schema = '".data::$database."'", false, false, false, true);
            foreach ($columns as $item){
                $col_name    = $item['COLUMN_NAME'];
                $col_type    = $item['COLUMN_TYPE'];
                $col_default = empty($item['COLUMN_DEFAULT'])?"NULL":$item['COLUMN_DEFAULT'];
                $class->setProp("public", $col_name);
                $class->setConstruct('$this->'.$col_name.' = new param();');
                $class->setConstruct('$this->'.$col_name.'->name="'.$col_name.'";');
                $class->setConstruct('$this->'.$col_name.'->type="'.$col_type.'";');
                $class->setConstruct('$this->'.$col_name.'->value="'.$col_default.'";');
                $class->setConstruct('array_push($this->cols,$this->'.$col_name.');');
        }

        $control = new classMaker("controller");
        $endSwitch = 'default:
                response::result(lang::$failed);
        }';
        $control->setNamespace("namespace control;");
        $control->setUse('use model\access\accessCreator;');
        $control->setUse($use);
        $control->setUse('use model\lang\lang;');
        $control->setConstruct($construct);
        $control->setFunction('public', 'detect_act', $detect);
        $control->setFunction('public', 'check', $check);
        $control->setFunction('public', 'set', $set.$endSwitch);
        $control->setFunction('public', 'get', $get.$endSwitch);
        $control->setFunction('public', 'delete', $delete.$endSwitch);
        $control->setFunction('public', 'edit', $edit.$endSwitch);
        $control->create('control/controller.php');

        echo "Accesses Created";

    }

}