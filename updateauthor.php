<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    exit;
}

if(!isset($_GET['author_name']) || !isset($_GET['request']) || !in_array($_GET['request'], array('add', 'delete'))) {
    exit;
}

$author_name = $_GET['author_name'];
$request = $_GET['request'];

$author_rollnumber = Pupil::getPupilRollNumberFromName($author_name);

$author = new Author($User->rollnumber, $author_rollnumber);

if($request == 'add') {
    
    // Add new author
    
    if($author->add()) {
        echo 'success';
    }else {
        echo 'failure';
    }
        
}else if($request == 'delete') {
    
    // Delete existing author
    
    if($author->delete()) {
        echo 'success';
    }else {
        echo 'failure';
    }
    
}