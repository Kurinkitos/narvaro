<?php

/**
 * Description of group
 *
 * @author Kurinkitos
 */
class group {
    private $id;
    private $name;
    private $usergroup;
    public function __construct($name, $usergroup, $id=null) {
        $this->name = $name;
        $this->id = $id;
        $this->usergroup = $usergroup;
    }
    public function getName(){
        return $this->name;
    }
    public function getId(){
        return $this->id;
    }
    public function getUsergroup(){
        return $this->usergroup;
    }
}

?>
