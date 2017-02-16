<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    exit;
}

$pupil = $_GET['pupil'];
$text = $_GET['text'];
$signature = $_GET['signature'];

$authorobj = new Author($pupil, $User->rollnumber);

$authorobj->editText($text);
$authorobj->editSignature($signature);
$authorobj->editStatus(0);
$authorobj->appendActivity("UPDATED TEXT: " . $text);
$authorobj->appendActivity("UPDATED SIGNATURE: " . $signature);

header("Location: http://yrbk.co/write.php");
die();