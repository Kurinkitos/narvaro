<?php
/**
 * Description of guardianFactory
 *
 * @author Kurinkitos
 */
class guardianFactory {
    public static function createGuardiansFromResult($result) {
        $guardians = array();
        while ($row = mysql_fetch_array($result))
        {
            $temp = new guardian($row['name'], $row['phone'], $row['id']);
            $guardians[] = $temp;
	}
        return $guardians;
    }
}

?>
