<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 5/20/2017
 * Time: 6:19 PM
 */

namespace model\database;
use PDO;
use PDOException;
class data{

    private static $server   = "localhost";
    public static $database = "elecstor_test";
    private static $username = "elecstor_tt";
    private static $password = "123123$#@!";
    private static $db;
    public static $develop_mode = false;

    private static function connect(){
        try{
            self::$db = new PDO("mysql:host=".self::$server.";dbname=".self::$database, self::$username, self::$password);
            self::$db->exec("SET NAMES 'utf8'");
            return true;
        }catch (PDOException $e){
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }

    private static function close(){
        self::$db = NULL;
    }

    public static function select($table, $cols = "*", $where = false, $orderByFiled = false, $orderType = "ASC", $limit = false, $fetchAll = false){
        if(self::connect()){
            try{
                $sql = "SELECT $cols FROM $table ".($where != false?" WHERE $where ":"").($orderByFiled!=false?" ORDER BY $orderByFiled ":"").($orderByFiled!=false?" $orderType ":"").($limit!=false?" LIMIT $limit":"");
                if (self::$develop_mode){echo $sql ; exit ;}
                $stmt = self::$db->prepare($sql);
                $stmt->execute();
                $result = $fetchAll == true?$stmt->fetchAll(PDO::FETCH_ASSOC):$stmt->fetch(PDO::FETCH_ASSOC);
                self::close();
                if(count($result) > 0){
                    return $result;
                }else{
                    return false;
                }
            }catch (PDOException $e){
                return $e->getMessage();
            }
        }
    }

    public static function selectJoin($table1, $table2 , $cols, $joinType = false, $on, $where = false, $orderByField = false, $orderType = "ASC", $limit, $fetchAll = false){
        if(self::connect()){
            try{
                $sql = "SELECT $cols FROM $table1".($joinType!=false?" $joinType JOIN $table2 ":" INNER JOIN $table2")." ON ".$on.($where!=false?" WHERE $where ":"").($orderByField!=false?" ORDER BY $orderByField ":"").($orderByField!=false?" $orderType ":"").($limit!=false?" LIMIT $limit":"");
                if (self::$develop_mode){echo $sql ; exit ;}
                $stmt = self::$db->prepare($sql);
                $stmt->execute();
                $result = $fetchAll == true?$stmt->fetchAll(PDO::FETCH_ASSOC):$stmt->fetch(PDO::FETCH_ASSOC);
                self::close();
                if(count($result > 0)){
                    return $result;
                }else{
                    return false;
                }
            }catch (PDOException $e){
                return $e->getMessage();
            }
        }
    }

    public static function insert($table, $cols, $values){
        if(self::connect()){
            try{
                $sql = "INSERT INTO $table ($cols) VALUES ($values)";
                if (self::$develop_mode){echo $sql ; exit ;}
                $stmt = self::$db->prepare($sql);
                $stmt->execute();
                $id = self::$db->lastInsertId();
                self::close();
                if ($stmt) {
                    return $id;
                } else {
                    return false;
                }
            }catch (PDOException $e){
                return $e->getMessage();
            }
        }
    }

    public static function update($table, $param, $where = false){
        if(self::connect()){
            try{
                $sql="UPDATE $table SET $param ".($where!= false?" WHERE $where":"");
                if (self::$develop_mode){echo $sql ; exit ;}
                $res = self::$db->exec($sql);
                self::close();
                if ($res) {
                    return true;
                } else {
                    return false;
                }
            }catch (PDOException $e){
                return $e->getMessage();
            }
        }
    }

    public static function delete($table, $where){
        if(self::connect()){
            try{
                $sql="DELETE FROM $table WHERE $where";
                if (self::$develop_mode){echo $sql ; exit ;}
                $res = self::$db->exec($sql);
                self::close();
                if ($res) {
                    return true;
                } else {
                    return false;
                }
            }catch (PDOException $e){
                return $e->getMessage();
            }
        }
    }

    public static function exec($command){}
}