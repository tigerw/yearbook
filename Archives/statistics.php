<?php

require('app.php');
require('templates/header.php');

if(!in_array($User->rollnumber, array(11830, 9216))) {
    echo '<div class="ui red segment"><h1>access denied, nerds only</h1></div>';
    exit;
}

?>

<div class="ui red segment">
    <h1>Statistics</h1>
</div>

<table class="ui celled striped table awards_table">
    <thead>
        <tr>
            <th>Award</th>
            <th>Nominated</th>
        </tr>
    </thead>
    <tbody>

<?php

$awards = DB::query("SELECT * FROM awards");


foreach($awards as $award) {

    $awardcount = DB::query("
    SELECT *, COUNT(value) as value_count
    FROM award_votes
    WHERE award_id = %i
    GROUP BY value
    ORDER BY value_count DESC
    LIMIT 10
    ", $award['id']);

?>

        <tr>
            <td><?=$award['award']?></td>
            <td>
<?php

foreach($awardcount as $pupil) {
    echo $pupil['value'] . " : " . $pupil['value_count'] . "<br/>";
}

?>

            </td>
        </tr>

<?php

}

?>



    </tbody>
</table>

<?php

require('templates/footer.php');
