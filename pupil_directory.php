<?php

require('app.php');
require('templates/header.php');

if(!in_array($User->rollnumber, array(11830, 9216))) {
    echo '<div class="ui red segment"><h1>access denied, nerds only</h1></div>';
    exit;
}

?>

<div class="ui red segment">
    <h1>Users Rollnumber Directory</h1>
</div>

<table class="ui celled striped table awards_table">
    <thead>
        <tr>
            <th>Pupil</th>
            <th>Rollnumber</th>
        </tr>
    </thead>
    <tbody>

<?php

$pupils = DB::query("SELECT * FROM pupils");
$complete = false;
$swaps_made = false;

while(true) {

    $swaps_made = false;

    for ($i = 1; $i < count($pupils); $i++) {

        if($pupils[$i - 1]['rollnumber'] > $pupils[$i]['rollnumber']) {
            $temp = $pupils[$i - 1];
            $pupils[$i - 1] = $pupils[$i];
            $pupils[$i] = $temp;
            $swaps_made = true;
        }
    }

    if($swaps_made == false) {
        break;
    }
}

foreach($pupils as $pupil) {
?>

    <tr>
        <td><?=$pupil['firstname']?> <?=$pupil['secondname']?></td>
        <td><?=$pupil['rollnumber']?></td>
    </tr>

<?php
} 

?>



    </tbody>
</table>

<?php

//print_r($pupils);

require('templates/footer.php');
