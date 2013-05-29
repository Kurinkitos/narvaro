<?php
/**
 * Description of groupFactory
 *
 * @author Kurinkitos
 */
class groupFactory {
    public static function createGroupsFromResult($result) {
        $groups = array();
        while ($row = mysql_fetch_array($result))
        {
            $temp = new group($row['name'], $row['usergroup'], $row['id']);
            $groups[] = $temp;
	}
        return $groups;
    }
}

?>
