<?php
/**
 * Description of studentFactory
 *
 * @author Kurinkitos
 */
class studentFactory {
    public static function createStudentsFromResult($result) {
        $students = array();
        while ($row = mysql_fetch_array($result))
        {
            $temp = new student($row['name'], $row['group'], $row['id']);
            $students[] = $temp;
	}
        return $students;
    }
}

?>
