<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    header( 'Location: index.php' ) ;
    exit;
}

require('templates/header.php');

?>        


    <div class="ui segment">
        <h1>Manage your photos</h1>
    </div>

    <div class="ui segment">
        <h1>First school photo</h1>
        <img class="ui medium rounded image" src="/photo_get.php?type=school_photo&rollnumber=<?=$User->rollnumber?>"/>
    </div>

    <div class="ui segment">
        <h1>Current Photo</h1>
        <?php
            if($User->currentphoto != "") {
?>
                <img class="ui medium rounded image" src="/photo_get.php?type=current&rollnumber=<?=$User->rollnumber?>"/>

<?php
            }
        ?>


        <form action="photo_upload.php" method="post" enctype="multipart/form-data" class="ui form">
            <div class="field">
                <label>Choose an image to upload. Max 1mb in size, image will be cropped automatically to the center to make it fit. If it doesn't crop right, try cropping the photo yourself and reuploading it.</label>
                <input type="file" name="photo" size="25" />
            </div>
            <input type="hidden" name="photo_type" value="current"/>
            <input class="ui button" type="submit" name="submit" value="Upload" />
        </form>
    </div>

    <div class="ui segment">
        <h1>Baby Photo</h1>
        <?php
            if($User->babyphoto != "") {
?>
                <img class="ui medium rounded image" src="/photo_get.php?type=baby&rollnumber=<?=$User->rollnumber?>"/>

<?php
            }
        ?>


        <form action="photo_upload.php" method="post" enctype="multipart/form-data" class="ui form">
            <div class="field">
                <label>Choose an image to upload. Max 1mb in size, image will be cropped automatically to the center to make it fit. If it doesn't crop right, try cropping the photo yourself and reuploading it.</label>
                <input type="file" name="photo" size="25" />
            </div>
            <input type="hidden" name="photo_type" value="baby"/>
            <input class="ui button" type="submit" name="submit" value="Upload" />
        </form>
    </div>

<?php

require('templates/footer.php');

?>