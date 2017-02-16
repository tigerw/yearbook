<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    exit;   
}

if(isset($_GET['awardid']) && $_GET['value']) {
    $awardid = $_GET['awardid'];
    $value = $_GET['value'];
}else {
    echo "failure";
    exit;
}

if($awardid == "" && $value == "") {
    echo "failure";
    exit;
}

if($value == "*") {
    DB::delete('award_votes', 'award_id=%i AND rollnumber=%i', $awardid, $User->rollnumber);
    echo "success";
    exit;
}else {
    $award_exists = DB::queryFirstRow("SELECT * FROM award_votes WHERE award_id=%i AND rollnumber=%i", $awardid, $User->rollnumber);
    if(!empty($award_exists)) {
        DB::update(
            'award_votes',
            array(
                'value' => $value  
            ),
            'award_id=%i AND rollnumber=%i',
            $awardid,
            $User->rollnumber
        );
        echo "success";
        exit;
    }else {
        DB::insert(
            'award_votes',
            array(
                'rollnumber' => $User->rollnumber,
                'award_id' => $awardid,
                'value' => $value
            )
        );
        echo "success";
        exit;
    }
}

?>