<?php

/**
 * Description of event
 *
 * @author Kurinkitos
 */
class event {
    private $student;
    private $guardian;
    private $time;
    private $type;
    public function __construct($student, $guardian, $time, $type) {
        $this->student = $student;
        $this->guardian = $guardian;
        $this->time = $time;
        $this->type = $type;
    }
    public function getStudent(){
        return $this->student;
    }
    public function getGuardian(){
        return $this->guardian;
    }
    public function getTime(){
        return $this->time;
    }
    public function getType(){
        return $this->type;
    }
}

?>
