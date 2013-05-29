<?php
    require_once 'databaseHandler.php';
    $handeler = new databaseHandler();
    if(isset($_POST['type'])){
        switch($_POST['type']){
            case "addStudent":
                $student = new student(mysql_real_escape_string($_POST['name']), mysql_real_escape_string($_POST['group']));
                $handeler->addStudent($student);
                echo "Student <i>" . mysql_real_escape_string($_POST['name']) . " </i>added to database";
                break;
            case "addGuardian":
                $guardian = new guardian(mysql_real_escape_string($_POST['name']), mysql_real_escape_string($_POST['phone']));
                $handeler->addGuardian($guardian);
                echo "Guardian <i>" . mysql_real_escape_string($_POST['name']) . " </i>added to database";
                break;
            case "addGroup":
                $group = new group(mysql_real_escape_string($_POST['name']));
                $handeler->addGroup($group);
                echo "Group <i>" . mysql_real_escape_string($_POST['name']) . " </i>added to database";
                break;
            case "addRelation":
                $student = new student("", null, $_POST['student']);
                $guardian = new guardian("", null, $_POST['guardian']);
                $handeler->addRelation($student, $guardian);
                echo "Relation added";
                break;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Database Test</title>
        <style>.float{/*float: left;*/}</style>
    </head>
    <body>
        <fieldset class="float">
        	<legend>Add Student</legend>
		<form method='post'>
			<table>
				<tr><td>Name:</td><td><input type="text" name="name"></td></tr>
                                <tr><td>Group:</td><td>
                                        <select name="group">
<?php
    $groups = $handeler->getAllGroups();
    for($i=0; $i < count($groups); $i++){
        echo "<option value='" . $groups[$i]->getId() . "'>" . $groups[$i]->getName() . "</option>";
    }
?>
                                        </select></td></tr>
                                <input type="hidden" name="type" value="addStudent"/>
				<tr><td><input type='submit' value='Submit'/></td></tr>
			</table>
		</form>
	</fieldset>
        <fieldset class="float">
        	<legend>Add Guardian</legend>
		<form method='post'>
			<table>
				<tr><td>Name:</td><td><input type="text" name="name"></td></tr>
				<tr><td>Phone:</td><td><input type='text' name='phone'/></td></tr>
                                <input type="hidden" name="type" value="addGuardian"/>
				<tr><td><input type='submit' value='Submit'/></td></tr>
			</table>
		</form>
	</fieldset>
        <fieldset class="float">
        	<legend>Add Group</legend>
		<form method='post'>
			<table>
				<tr><td>Name:</td><td><input type="text" name="name"></td></tr>
                                <input type="hidden" name="type" value="addGroup"/>
				<tr><td><input type='submit' value='Submit'/></td></tr>
			</table>
		</form>
	</fieldset>
        <fieldset class="float">
        	<legend>Add Relation</legend>
		<form method='post'>
			<table>
                                <input type="hidden" name="type" value="addRelation"/>
                                <tr><td>Student:</td><td>
                                        <select name="student">
<?php
    $students = $handeler->getAllStudents();
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
				<tr><td><input type='submit' value='Submit'/></td></tr>
			</table>
		</form>
	</fieldset>
        <fieldset class="float">
            <legend>Students</legend>
            <table>
                <th>Id</th><th>Name</th><th>Group</th>
<?php
    $students = $handeler->getAllStudents();
    for($i=0; $i < count($students); $i++){
        echo "<tr>";
        echo "<td>" . $students[$i]->getId() . "</td>";
        echo "<td>" . $students[$i]->getName() . "</td>";
        //Fetch the group name
        echo "<td>" . $handeler->getGroupById($students[$i]->getGroup())->getName() . "</td>";
        echo "</tr>";
    }
?>
            </table>
        </fieldset>
        <fieldset class="float">
            <legend>Guardians</legend>
            <table>
                <th>Id</th><th>Name</th><th>Phone</th>
<?php
    $guardians = $handeler->getAllGuardians();
    for($i=0; $i < count($guardians); $i++){
        echo "<tr>";
        echo "<td>" . $guardians[$i]->getId() . "</td>";
        echo "<td>" . $guardians[$i]->getName() . "</td>";
        echo "<td>" . $guardians[$i]->getPhone() . "</td>";
        echo "</tr>";
    }
?>
            </table>
        </fieldset>
        <fieldset class="float">
            <legend>Groups</legend>
            <table>
                <th>Id</th><th>Name</th>
<?php
    $groups = $handeler->getAllGroups();
    for($i=0; $i < count($groups); $i++){
        echo "<tr>";
        echo "<td>" . $groups[$i]->getId() . "</td>";
        echo "<td>" . $groups[$i]->getName() . "</td>";
        echo "</tr>";
    }
?>
            </table>
        </fieldset>
    </body>
</html>