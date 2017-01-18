<?php

require('app.php');

$type = $_GET['type'];
$rollnumber = sprintf('%05d', $_GET['rollnumber']);

if(!$type || !$rollnumber) {
    echo 'error';
    die;
}

$result = DB::QueryFirstRow('SELECT * FROM pupils WHERE rollnumber=%s', $rollnumber);

if(!$result) {
    echo 'db error';
    die;
}

if($type == 'current') {
    if($result['currentphoto'] != "") {
        $tmp_img_path = $result['currentphoto'];
    }else {
        $tmp_img_path = "images/defaultcurrent.jpg";
    }
}else if($type == 'baby') {
    if($result['babyphoto'] != "") {
        $tmp_img_path = $result['babyphoto'];
    }else {
        $tmp_img_path = "images/defaultbaby.jpg";
    }
}else if($type == 'school_photo'){
    $tmp_img_path = 'media/school_photo/'.$rollnumber.'.JPG';
}else if($type == 'thumb'){
    $tmp_img_path = 'media/school_photo/'.$rollnumber.'.JPG';
}

$img = new abeautifulsite\SimpleImage($tmp_img_path);

if($type == 'current') {
    //$img->fit_to_height(1200);
    //$img->crop(($img->get_width() - 900)/2,0 ,$img->get_width() - ($img->get_width() - 900)/2 ,900);
    $img->thumbnail(900, 900);
    $img->output();
}else if($type == 'baby' || $type == 'school_photo') {
    $img->fit_to_height(420);
    $img->crop(($img->get_width() - 260)/2,0 ,$img->get_width() - ($img->get_width() - 260)/2 ,420);
    $img->output();
}else if($type == 'thumb') {
    $img->thumbnail(420, 420);
    $img->output();
}