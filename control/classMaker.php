<?php
/**
 * Created by PhpStorm.
 * User: amir's dell
 * Date: 6/11/2017
 * Time: 6:31 PM
 */

namespace control;
class classMaker{

    private $namespcae = "";
    private $use   = "";
    private $class = "";
    private $prop  = "";
    private $construct = "public function __construct(){\n";
    private $function  = "";

    function __construct($className, $extend = false){
        if($extend != false){
            $this->class .= "class $className extends $extend{\n";
        }else{
            $this->class .= "class $className {\n";
        }
    }

    public function setNamespace($namespace){
        $this->namespcae .= $namespace."\n";
    }

    public function setUse($use){
        $this->use .= $use."\n";
    }

    public function setProp($type, $prop){
        $this->prop .= "$type $$prop;\n";
    }

    public function setConstruct($str){
        $this->construct .= $str."\n";
    }

    public function setFunction($type, $name, $code){
        $this->function .= $type.' function '.$name.'(){'.$code.'}'."\n";
    }

    public function create($path){
        $class = "<?php \n".$this->namespcae.$this->use.$this->class.$this->prop.$this->construct."}\n".$this->function."\n} ?>";
        $fp=fopen($path,'w');
        fwrite($fp, $class);
        fclose($fp);
    }
}