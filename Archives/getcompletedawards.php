<?php

require('app.php');

$votes = DB::query("SELECT * FROM award_votes WHERE rollnumber = %i", $User->rollnumber);

$result = array();

foreach($votes as $vote) {
    $result[$vote['award_id']] = $vote['value'];
}

echo json_encode($result, 1);

?>