<?php

require('app.php');
require('templates/header.php');

if(!in_array($User->rollnumber, array(11830, 9216))) {
    echo '<div class="ui red segment"><h1>access denied, nerds only</h1></div>';
    exit;
}

?>

<div class="ui red segment">
    <h1>Author Submission Statistics</h1>
</div>


<table class="ui celled striped table awards_table">
    <thead>
        <tr>
            <th>Pupil Rollnumber</th>
            <th>Pupil Name</th>
            <th>Authors</th>
        </tr>
    </thead>
    <tbody>

<?php

$pupils = DB::query("SELECT firstname, secondname, rollnumber FROM pupils");
$authors_count_query = DB::query("SELECT pupil_rollnumber, COUNT(pupil_rollnumber) as authors FROM author_choices GROUP BY pupil_rollnumber ORDER BY authors");
$pupil_index = array();

foreach($pupils as $pupil) {

    $pupil_index[$pupil['rollnumber']] = $pupil['firstname'] . ' ' . $pupil['secondname'];

}

$authors_with_submissions = $pupil_index;

foreach($authors_count_query as $author_count) {
    unset($authors_with_submissions[$author_count['pupil_rollnumber']]);
}

foreach($authors_with_submissions as $key=>$author) {
?>

        <tr>
            <td><?=$key?></td>
            <td><?=$author?></td>
            <td class="negative">0</td>
        </tr>

<?php
}

foreach($authors_count_query as $author_count) {
?>
        <tr>
            <td><?=$author_count['pupil_rollnumber']?></td>
            <td><?=$pupil_index[intval($author_count['pupil_rollnumber'])]?></td>
            <td class="<?php if($author_count['authors'] < 5) { echo "warning";}else {echo "positive";}?>"><?=$author_count['authors']?></td>
        </tr>
<?php
}
?>

    </tbody>

</table>

<?php

require('templates/footer.php');