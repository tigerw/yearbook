<?php

require('app.php');
require('templates/header.php');

if(!in_array($User->rollnumber, array(11830, 9216, 9237, 9340))) {
    echo '<div class="ui red segment"><h1>access denied, nerds only</h1></div>';
    exit;
}

$tmp_unwritten = DB::query("SELECT * FROM author_choices WHERE text=''");
$unwritten = array();

foreach($tmp_unwritten as $fool) {
    array_push($unwritten, ($fool['author_rollnumber'] . " -> " . $fool['pupil_rollnumber']));
}

?>

<div class="ui red segment">
    <h1>Moderate Writing</h1>
    <p><?=count($unwritten)?> unwritten</p>
</div>

<table class="ui celled striped table">
    <thead>
        <tr>
            <th>Author</th>
            <th>Pupil's they've written for</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

<?php

$authors = DB::query("SELECT * FROM pupils ORDER BY secondname");

$pupilmap = Pupil::getPupilNameArray();

foreach($authors as $author) {

?>

        <tr>
            <td><?=$author['firstname']?> <?=$author['secondname']?></td>
            <td>

<?php
    
    $tmp_writing_for = DB::query('SELECT * FROM author_choices WHERE author_rollnumber=%i', $author['rollnumber']);
    foreach($tmp_writing_for as $pupil) {

        if($pupil['status'] == 0) {
            echo '<div class="ui grey label" style="margin-bottom: 5px;">Unchecked</div> ';
        }else if($pupil['status'] == 1) {
            echo '<div class="ui green label" style="margin-bottom: 5px;">Accepted</div> ';
        }else if($pupil['status'] == 2) {
            echo '<div class="ui red label" style="margin-bottom: 5px;">Rejected</div> ';
        }

        if(in_array($author['rollnumber'] . " -> " . $pupil['pupil_rollnumber'], $unwritten)) {
            echo '<div class="ui red label" style="margin-bottom: 5px;">';
        }else {
            echo '<div class="ui green label" style="margin-bottom: 5px;">';
        }

        echo $pupilmap[$pupil['pupil_rollnumber']] . "</div><br/>";
    }

?>

            </td>
            <td>
                <a href="/moderate_view.php?select=unchecked&rollnumber=<?=$author['rollnumber']?>">View Unchecked</a><br/>
                <a href="/moderate_view.php?select=all&rollnumber=<?=$author['rollnumber']?>">View All</a><br/>
            </td>
        </tr>

<?php

}

?>



    </tbody>
</table>

<?php

require('templates/footer.php');
