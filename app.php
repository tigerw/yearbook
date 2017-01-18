<?php

require('lib/meekrodb.2.3.class.php');
require('lib/SimpleImage.php');

/* INCLUDE CUSTOM CLASSES */

require('yearbook/pupil.class.php');
require('yearbook/pupilauth.class.php');
require('yearbook/author.class.php');

/* FINISH CUSTOM CLASSES */

session_start();

DB::$host = '';
DB::$user = '';
DB::$password = '';
DB::$dbName = '';


if(PupilAuth::isLoggedIn()) {
    $User = new Pupil();
    $User->setWithRollNumber($_SESSION['pupilrolenumber']);
}