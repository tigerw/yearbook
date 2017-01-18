<?php

require('app.php');

$pupil_rollnumber = $_GET['rollnumber'];

if($pupil_rollnumber == "") {
    die;
}

$pupil = new Pupil();
$pupil->setWithRollNumber($pupil_rollnumber);

$yearjoined = 2002 + $pupil->yearjoined;

if($pupil->yearjoined == "") {
    $yearjoined = 2009;
}

?>

<html>

<header>

    <style>

    html, body {
        margin: 0 0 0 0;
        padding: 0 0 0 0;
    }
        
    .page {
        margin: 0 0 0 0;
        width: 2480px;
        height: 3508px;
        overflow: hidden;
        background-color: white;
    }

    .header {
        margin-top: 120px;
        margin-bottom: 60px;
        width: 100%;
        height: 1240px;
        float: left;
        background-color: rgba(255,255,255,1);
        position: relative;
    }

    .photo-main {
        margin-top: 60px;
        margin-left: 630px;
        height: 900px;
        float: left;
    }

    .photos-secondary {
        float: left;
        height: 900px;
        margin-left: 60px;
        margin-top: 60px;
        width: 260px;
    }

    .photos-secondary img {
        float: left;
    }

    .details {
        float: left;
        clear: both;
        margin-top: 20px;
        font-family: "Times New Roman", Times, serif;
        font-weight: normal;
        width: 100%;
        text-align: center;
    }


    .details h1 {
        font-size: 120px;
        margin: 0;
        color: #404041;
        font-weight: normal;
    }

    .details p {
        display: inline-box;
        margin: 0;
        margin-bottom: 10px;
        font-size: 60px;
        color: #58585b;
        font-weight: normal;
    }

    .details div.house {
        background: #ac877f;
        padding: 20px 40px 20px 40px;
        display: inline-block;
        width: auto;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        border-radius: 20px;
        font-size: 60px;
        color: #FFF;
    }

    .questions {
        float: left;
        width: 100%;
        padding-top: 20px;
        padding-bottom: 30px;
        font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
        text-align: center;
        font-weight: normal;
    }

    .questions p.answer {
        color: #231f20;
        margin: 0;
        font-size: 50px;

    }

    .questions p.question {
        color: #808080;
        margin: 0;
        font-size: 30px;

    }

    div.question-space {
        margin: 0;
        margin-bottom: 20px;
        overflow: visible;
    }

    div.question-border-a {
        overflow: visible;
        float: left;
        background-color: #808284;
        width: 100%;
        height: 20px;
    }

    div.question-border-b {
        overflow: visible;
        float: left;
        background-color: #bbbdc0;
        width: 100%;
        height: 20px;
    }

    div.statements {
        font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
        padding-left: 120px;
        padding-right: 120px;
        text-align: justify;
    }

    div.statements p.statement{
        color: #231f20;
        font-size: 34px;
        display: inline-block;
        float: left;
        margin: 0;
        margin-top: 60px;
    }

    div.statements span.signature{
        color: #6d6e70;
    }

hr {
  border: 0;
  border-top: 10px double #8c8c8c;
  width: 2240px;
}
    img.circular {
        margin-top: 15px;
        width: 250px; height: auto;
        float: left;
        border-radius: 50%;
        -webkit-shape-outside:circle();
        shape-outside:circle();
        margin-right: 50px;
    }


    </style>

</header>

    <body>

        <div class="page">

            <div class="header">

                <div class="photo-main">
                    <img src="/photo_get.php?type=current&rollnumber=<?=$pupil_rollnumber?>">
                    <!--<img src="/media/school_photos/<?=$pupil->rollnumber?>.JPG"/>-->
                </div>
                <div class="photos-secondary">
                    <img src="/photo_get.php?type=baby&rollnumber=<?=$pupil_rollnumber?>" style="margin-bottom: 60px">
                    <img src="/photo_get.php?type=school_photo&rollnumber=<?=$pupil_rollnumber?>">
                </div>


                <div class="details">
                    <h1><?=$pupil->firstname?> <?=$pupil->secondname?></h1>
                    <p><?=$yearjoined?> - 2016 | <?=$pupil->house?></p>
                </div>

            </div>

            <hr>

            <div class="questions">

                <?php if($pupil->firstquestion != "") { ?>

                <p class="question"><?=Pupil::getQuestion($pupil->firstquestion)?>...</p>
                <p class="answer"><i>&ldquo;<?=$pupil->firstanswer?>&rdquo;</i></p>
                <div class="question-space"></div>

                <?php } if($pupil->secondquestion != "") {?>

                <p class="question"><?=Pupil::getQuestion($pupil->secondquestion)?>...</p>
                <p class="answer"><i>&ldquo;<?=$pupil->secondanswer?>&rdquo;</i></p>

                <?php } ?>

            </div>

            <hr>

            <div class="statements">

<?php

// GENERATE THE PROFILE ENTRIES

$authors = Author::getCurrentAuthors($pupil->rollnumber);

foreach($authors as $author) {

    $author_obj = new Author($pupil_rollnumber, $author);
    $author_obj->fetchDetails();

?>
                <p class="statement"><img src="/photo_get.php?type=thumb&rollnumber=<?=$author?>" class="circular"><?=$author_obj->author_text?><br/><span class="signature"><?=$author_obj->author_signature?></span></p>
<?php

}

?>

            </div>

        </div>

    </body>

</html>