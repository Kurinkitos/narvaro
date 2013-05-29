<?php

/**
 * Description of guardian
 *
 * @author Kurinkitos
 */
class guardian {
    private $id;
    private $name;
    private $phone;
    public function __construct($name, $phone, $id=false) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getPhone(){
        return $this->phone;
    }
    public function dumpInfo(){
        echo "Dumping Guardian info: </br>";
        echo "Id: " . $this->getId() . "</br>";
        echo "Name: " . $this->getName() . "</br>";
        echo "Phone : " . $this->getPhone() . "</br>";
        echo "Done </br>";
    }
}

?>
