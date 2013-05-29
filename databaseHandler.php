<?php

require_once 'database.php';
require_once 'student.php';
require_once 'guardian.php';
require_once 'group.php';
require_once 'event.php';
require_once 'studentFactory.php';
require_once 'guardianFactory.php';
require_once 'groupFactory.php';
require_once 'eventFactory.php';
/**
 * Description of databaseHandler
 *
 * @author Kurinkitos
 */
class databaseHandler {
    private $database;
    public function __construct() {
        $this->database = new database("localhost", "root", "", "narvaro");
    }
    public function __destruct() {
        $this->closeConnection();
    }
    public function closeConnection() {
        $this->database->closeConnection();
    }
    public function getStudentById($id){
        $result = $this->query("SELECT * FROM student WHERE id=$id");
        if($result != 0){
            $row = mysql_fetch_array($result);
            return new student($row['name'], $row['group'], $row['id']);
        }
    }
    public function getStudentsByIdArray($ids){
        if(count($ids) < 1){
            return null;
        }
        $query = "SELECT * FROM student WHERE id=";
        for($i=0; $i < count($ids); $i++){
            if($i == 0){
                $query .= $ids[$i];
            }
            else{
                $query .= " OR id=$ids[$i]";
            }
        }
        $result = $this->query($query);
        $students = studentFactory::createStudentsFromResult($result);
        return $students;
    }
    public function getStudentsByExcludingIdArray($ids){
        if(count($ids) < 1){
            $query = "SELECT * FROM student";
        }
        else{
            $query = "SELECT * FROM student WHERE id!=";
            for($i=0; $i < count($ids); $i++){
                if($i == 0){
                    $query .= $ids[$i];
                }
                else{
                    $query .= " AND id!=$ids[$i]";
                }
            }
        }
        $result = $this->query($query);
        $students = studentFactory::createStudentsFromResult($result);
        return $students;
    }
    public function getGuardianById($id){
        $result = $this->query("SELECT * FROM guardian WHERE id=$id");
        if($result != 0){
            $row = mysql_fetch_array($result);
            return new guardian($row['name'], $row['phone'], $row['id']);
        }
    }
    public function getGuardians($student){
        $guardians = array();
        $query = "SELECT guardian FROM relations WHERE student=" . $student->getId();
        $result = $this->query($query);
        while ($row = mysql_fetch_array($result))
        {
            $guardians[] = $row['guardian'];
	}
        $query = "SELECT * FROM guardian WHERE id=";
        for($i=0; $i < count($guardians); $i++){
            if($i == 0){
                $query .= $guardians[$i];
            }
            $query .= " OR $guardians[$i]";
        }
        $result = $this->query($query);
        $guardians = guardianFactory::createGuardiansFromResult($result);
        return $guardians;
    }
    public function getGroupById($id){
        $result = $this->query("SELECT * FROM groups WHERE id = $id");
        if($result != 0){
            $row = mysql_fetch_array($result);
            return new group($row['name'], $row['id']);
        }
    }
    public function addStudent($student){
        $query = "INSERT INTO student (name, `group`) VALUES ('" . $student->getName() . "', " . $student->getGroup() . ")";
        $this->query($query);
    }
    public function addGuardian($guardian){
        $query = "INSERT INTO guardian (name, phone) VALUES ('" . $guardian->getName() . "','" . $guardian->getPhone() . "')";
        $this->query($query);
    }
    public function addRelation($student, $guardian){
        $query = "INSERT INTO relations (student, guardian) VALUES (" . $student->getId() . "," . $guardian->getId() . ")";
        $this->query($query);
    }
    public function addGroup($group){
        $query = "INSERT INTO groups (name, usergroup) VALUES ('" . $group->getName() . "', " . $group->getUsergroup() . ")";
        $this->query($query);
    }
    public function addPresentStudent($student, $guardian, $arrived){
        $query = "INSERT INTO presentStudents (student, arrived) VALUES (" . $student->getId() . ", $arrived)";
        $this->query($query);
        $this->addEvent(new event($student, $guardian, $arrived, 'arrived'));
    }
    public function removePresentStudent($student, $guardian, $left){
        if($this->isStudentPresent($student)){
            $query = "DELETE FROM presentStudents WHERE student=" . $student->getId();
            $this->query($query);
            $this->addEvent(new event($student, $guardian, $left, 'left'));
        }
    }
    public function addEvent($event){
        $student = $event->getStudent();
        $studentId = $student->getId();
        $guardian = $event->getGuardian();
        $guardianId = $guardian->getId();
        $time = $event->getTime();
        $type = $event->getType();
        $query = "INSERT INTO event (student, guardian, time, type) VALUES ($studentId, $guardianId, $time, '$type')";
        $this->query($query);
    }
    public function findStudentsByName($name){
        $result = $this->query("SELECT * FROM student WHERE name=$name");
        $students = studentFactory::createStudentsFromResult($result);
        return $students;
    }
    public function searchStudentsByName($name){
        $result = $this->query("SELECT * FROM student WHERE name=%$name%");
        $students = studentFactory::createStudentsFromResult($result);
        return $students;
    }
    public function getAllStudents(){
        $result = $this->query("SELECT * FROM student");
        $students = studentFactory::createStudentsFromResult($result);
        return $students;
    }
    public function getAllGuardians(){
        $result = $this->query("SELECT * FROM guardian");
        $guardians = guardianFactory::createGuardiansFromResult($result);
        return $guardians;
    }
    public function getAllGroups(){
        $result = $this->query("SELECT * FROM groups");
        $groups = groupFactory::createGroupsFromResult($result);
        return $groups;
    }
    public function getAllEvents(){
        $result = $this->query("SELECT * FROM event ORDER BY time DESC");
        $events = eventFactory::createEventsFromResult($result);
        return $events;
    }
    public function getPresentStudents(){
        $result = $this->query("SELECT student FROM presentStudents");
        $studentIds = array();
        while ($row = mysql_fetch_array($result))
        {
            $studentIds[] = $row['student'];
	}
        $students = $this->getStudentsByIdArray($studentIds);
        return $students;
    }
    public function getNotPresentStudents(){
        $result = $this->query("SELECT student FROM presentStudents");
        $studentIds = array();
        while ($row = mysql_fetch_array($result))
        {
            $studentIds[] = $row['student'];
	}
        $students = $this->getStudentsByExcludingIdArray($studentIds);
        return $students;
    }
    public function isStudentPresent($student){
        $result = $this->query("SELECT student FROM presentStudents WHERE student=" . $student->getId());
        if($result == 0){
            return false;
        }
        else{
            return true;
        }
    }
    public function getStudentArriveTime($student){
        $query = "SELECT arrived FROM presentStudents WHERE student=" . $student->getId();
        $result = $this->query($query);
        $row = mysql_fetch_array($result);
        return $row['arrived'];
    }
    private function query($query){
        $connection = $this->database->getConnection();
        $result = mysql_query($query, $connection);
        if(!$result){
            die("Query failed! " . mysql_error() . " Query: " . $query);
        }
        if($result == 0){
            return null;
        }
        return $result;
        
    }
}

?>
