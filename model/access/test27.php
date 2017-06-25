<?php 
namespace model\access;
use model\database\access;
use model\database\param;
class test27 extends access{
public $id;
public $Asdasd;
public $sadad;
public $asdasdas;
public function __construct(){
parent::__construct("test27");
$this->id = new param();
$this->id->name="id";
$this->id->type="int(11)";
$this->id->value="NULL";
array_push($this->cols,$this->id);
$this->Asdasd = new param();
$this->Asdasd->name="Asdasd";
$this->Asdasd->type="varchar(50)";
$this->Asdasd->value="NULL";
array_push($this->cols,$this->Asdasd);
$this->sadad = new param();
$this->sadad->name="sadad";
$this->sadad->type="timestamp";
$this->sadad->value="CURRENT_TIMESTAMP";
array_push($this->cols,$this->sadad);
$this->asdasdas = new param();
$this->asdasdas->name="asdasdas";
$this->asdasdas->type="text";
$this->asdasdas->value="NULL";
array_push($this->cols,$this->asdasdas);
}
public function getCols(){return $this->cols;}

} ?>