<?php
/**
 *
 *
 * @author Kurinkitos
 */
class student {
    private $id;
    private $name;
    private $group;
    
    public function __construct($name, $group, $id=false) {
        $this->id = $id;
        $this->name = $name;
        $this->group = $group;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getGroup(){
        return $this->group;
    }
}

?>
