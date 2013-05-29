<?php
    require_once 'databaseHandler.php';
    $handeler = new databaseHandler();
    if(isset($_POST['type'])){
        switch($_POST['type']){
            case "addPresent":
                $student = new student("", null, $_POST['student']);
                $guardian = new guardian("", null, $_POST['guardian']);
                $handeler->addPresentStudent($student, $guardian, time());
                break;
            case "removePresent":
                $student = new student("", null, $_POST['student']);
                $guardian = new guardian("", null, $_POST['guardian']);
                $handeler->removePresentStudent($student, $guardian, time());
                break;
            default: 
                echo "Unreconized type: " . $_POST['type'];
        }
    }
?>
<html>
    <head>
        <title>Attendance Test</title>
        <style>
        </style>
    </head>
    <body>
        <fieldset>
            <legend>Add Present Student</legend>
            <form method='post'>
                <table>
                        <tr><td>Student:</td><td>
                                <select name="student">
<?php
$students = $handeler->getNotPresentStudents();
for($i=0; $i < count($students); $i++){
echo "<option value='" . $students[$i]->getId() . "'>" . $students[$i]->getName() . "</option>";
}
?>
                                </select></td></tr>
                        <tr><td>Guardian:</td><td>
                                <select name="guardian">
<?php
$guardians = $handeler->getAllGuardians();
for($i=0; $i < count($guardians); $i++){
echo "<option value='" . $guardians[$i]->getId() . "'>" . $guardians[$i]->getName() . "</option>";
}
?>
                                </select></td></tr>
                        <input type="hidden" name="type" value="addPresent"/>
                        <tr><td><input type='submit' value='Submit'/></td></tr>
                </table>
            </form>
        </fieldset>
        <fieldset>
            <legend>Remove Present Student</legend>
            <form method='post'>
                <table>
                        <tr><td>Student:</td><td>
                                <select name="student">
<?php
$students = $handeler->getPresentStudents();
for($i=0; $i < count($students); $i++){
echo "<option value='" . $students[$i]->getId() . "'>" . $students[$i]->getName() . "</option>";
}
?>
                                </select></td></tr>
                        <tr><td>Guardian:</td><td>
                                <select name="guardian">
<?php
$guardians = $handeler->getAllGuardians();
for($i=0; $i < count($guardians); $i++){
echo "<option value='" . $guardians[$i]->getId() . "'>" . $guardians[$i]->getName() . "</option>";
}
?>
                                </select></td></tr>
                        <input type="hidden" name="type" value="removePresent"/>
                        <tr><td><input type='submit' value='Submit'/></td></tr>
                </table>
            </form>
        </fieldset>
        <fieldset>
            <legend>Present Students</legend>
            <table>
                <th>Id</th><th>Name</th><th>Group</th><th>Arrived</th>
<?php
    $students = $handeler->getPresentStudents();
    for($i=0; $i < count($students); $i++){
        echo "<tr>";
        echo "<td>" . $students[$i]->getId() . "</td>";
        echo "<td>" . $students[$i]->getName() . "</td>";
        //Fetch the group name
        echo "<td>" . $handeler->getGroupById($students[$i]->getGroup())->getName() . "</td>";
        //Fetch the arrived time
        echo "<td>" . date('Y-m-d H:i:s', $handeler->getStudentArriveTime($students[$i])) . "</td>";
        echo "</tr>";
    }
?>
            </table>
        </fieldset>
        <fieldset>
            <legend>Log</legend>
            <table>
                <th>Student</th><th>Guardian</th><th>Time</th><th>Type</th>
<?php
    $events = $handeler->getAllEvents();
    for($i=0; $i < count($events); $i++){
        $student = $handeler->getStudentById($events[$i]->getStudent());
        $guardian = $handeler->getGuardianById($events[$i]->getGuardian());
        echo "<tr>";
        echo "<td>" . $student->getName() . "</td>";
        echo "<td>" . $guardian->getName() . "</td>";
        echo "<td>" . date('Y-m-d H:i:s', $events[$i]->getTime()) . "</td>";
        echo "<td>" . $events[$i]->getType() . "</td>";
        echo "</tr>";
    }
?>
            </table>
        </fieldset>
    </body>
</html>
