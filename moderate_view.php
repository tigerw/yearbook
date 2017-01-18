<?php

require('app.php');
require('templates/header.php');

if(!in_array($User->rollnumber, array(11830, 9216, 9237, 9340))) {
    echo '<div class="ui red segment"><h1>access denied, nerds only</h1></div>';
    exit;
}

$pupil_rollnumber = $_GET['rollnumber'];
$pupil_select = $_GET['select'];

?>

<div class="ui red segment">
    <h1>Moderate Writing: View</h1>
    <a href="/moderate.php">Back<a/>
</div>

<table class="ui celled striped table">
    <thead>
        <tr>
            <th>Pupil</th>
            <th>Text</th>
            <th>Signature</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

<?php

if($pupil_select == 'all') {
    $entries = DB::query('SELECT * FROM author_choices WHERE author_rollnumber=%i', $pupil_rollnumber);
}else if($pupil_select == 'unchecked') {
    $entries = DB::query('SELECT * FROM author_choices WHERE author_rollnumber=%i AND status = 0', $pupil_rollnumber);
}

foreach($entries as $entry) {

    $tmp_name = Pupil::getPupilNameByRollnumber($entry['pupil_rollnumber']);

?>

        <tr>
<?php
if($entry['status'] == 0) {
    echo '<td class="grey">';
}else if($entry['status'] == 1) {
    echo '<td class="positive">';
}else if($entry['status'] == 2) {
    echo '<td class="negative">';
}
?>

            <?=$tmp_name?> (<?=$entry['pupil_rollnumber']?>)</td>
            <td><?=$entry['text']?></td>
            <td><?=$entry['signature']?></td>
            <td>
                <a href="/updatemoderate.php?pupil=<?=$entry['pupil_rollnumber']?>&author=<?=$entry['author_rollnumber']?>&action=accept" class="ui green button" style="margin-bottom: 5px;">Accept</a><br/>
                <a href="/moderatorwrite.php?pupil=<?=$entry['pupil_rollnumber']?>&author=<?=$entry['author_rollnumber']?>" class="ui button" style="margin-bottom: 5px;">Edit</a><br/>
                <a href="/updatemoderate.php?pupil=<?=$entry['pupil_rollnumber']?>&author=<?=$entry['author_rollnumber']?>&action=reject" class="ui red button" >Reject</a>
            </td>
        </tr>
<?php
}
?>

    </tbody>
    <tbody>

</table>

<?php

require('templates/footer.php');
