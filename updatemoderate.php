<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    exit;
}

if(!in_array($User->rollnumber, array(11830, 9216, 9237, 9340))) {
    echo '<div class="ui red segment"><h1>access denied, nerds only</h1></div>';
    exit;
}

$pupil = $_GET['pupil'];
$author = $_GET['author'];
$text = $_GET['text'];
$signature = $_GET['signature'];
$action = $_GET['action'];

$authorobj = new Author($pupil, $author);

if($action == "accept") {
    $authorobj->editStatus(1);
    $authorobj->appendActivity("APPLICATION ACCEPTED BY " . $User->firstname . " " . $User->secondname);
}else if($action == "reject") {
    $authorobj->editStatus(2);
    $authorobj->appendActivity("APPLICATION REJECTED BY " . $User->firstname . " " . $User->secondname);
}else if($action == "edit") {

    $authorobj->editText($text);
    $authorobj->editSignature($signature);
    $authorobj->editStatus(0);
    $authorobj->appendActivity("UPDATED TEXT: " . $text);
    $authorobj->appendActivity("UPDATED SIGNATURE: " . $signature);
    $authorobj->appendActivity("APPLICATION EDITED BY " . $User->firstname . " " . $User->secondname);

}

header("Location: http://yrbk.co/moderate_view.php?select=all&rollnumber=" . $author);
die();