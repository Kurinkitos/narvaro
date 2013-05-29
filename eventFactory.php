<?php
/**
 * Description of eventFactory
 *
 * @author Kurinkitos
 */
class eventFactory {
    public static function createEventsFromResult($result) {
        $events = array();
        while ($row = mysql_fetch_array($result))
        {
            $temp = new event($row['student'], $row['guardian'], $row['time'], $row['type']);
            $events[] = $temp;
	}
        return $events;
    }
}

?>
