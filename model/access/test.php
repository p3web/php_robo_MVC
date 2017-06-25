<?php 
namespace model\access;
use model\database\access;
use model\database\param;
class test extends access{
public $id;
public $name;
public function __construct(){
parent::__construct("test");
$this->id = new param();
$this->id->name="id";
$this->id->type="int(11)";
$this->id->value="NULL";
array_push($this->cols,$this->id);
$this->name = new param();
$this->name->name="name";
$this->name->type="varchar(50)";
$this->name->value="NULL";
array_push($this->cols,$this->name);
}
public function getCols(){return $this->cols;}

} ?>