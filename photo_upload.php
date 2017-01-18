<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    header( 'Location: index.php' ) ;
    exit;
}

require('templates/header.php');

?>
    <div class="ui segment">

        <h1>Photo upload result:</h1>
        <p>
<?php

$photo_path = "";
if($_POST['photo_type'] == "current") {
    $photo_path = "current";
}else if($_POST['photo_type'] == "baby") {
    $photo_path = "baby";
}else {
    die;
}

if($_FILES['photo']['name'])
{
    //if no errors...
    if(!$_FILES['photo']['error'])
    {
        //now is the time to modify the future file name and validate the file
        $new_file_name = strtolower($_FILES['photo']['tmp_name']); //rename file
        $valid_file = true;
        if($_FILES['photo']['size'] > (1024000)) //can't be larger than 1 MB
        {
            $valid_file = false;
            echo 'Your file\'s size is to large.';
        }
        
        if($valid_file)
        {
            $tmp_path = 'media/'.$photo_path.'/'.$User->rollnumber.'.JPG';
            if(file_exists($tmp_path)) {
                unlink($tmp_path);
            }
            move_uploaded_file($_FILES['photo']['tmp_name'], $tmp_path);
            if($photo_path == "current") {
                DB::update('pupils', array('currentphoto' => $tmp_path), 'rollnumber=%s', $User->rollnumber);
            }else if($photo_path == "baby") {
                DB::update('pupils', array('babyphoto' => $tmp_path), 'rollnumber=%s', $User->rollnumber);
            }
            echo 'Your file was uploaded successfully.';
        }else {
            echo 'failed';
        }
    }
    //if there is an error...
    else
    {
        //set that to be the returned message
        echo 'Your upload triggered the following error:  '.$_FILES['photo']['error'];
    }
}
?>
    <br/><a href="/photos.php">Click here to go back</a>
    </p>
    </div>
<?php
require('templates/footer.php');

?>