<?php

require('app.php');

$pupil_rollnumber = $_GET['rollnumber'];

if($pupil_rollnumber == "") {
    die;
}

$pupil = new Pupil();
$pupil->setWithRollNumber($pupil_rollnumber);

$yearjoined = 2002 + $pupil->yearjoined;

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
        margin-top: 60px;
        margin-bottom: 0px;
        margin-left: 120px;
        margin-right: 120px;
        width: 2240px;
        height: 140px;
        float: left;
        background-color: rgba(255,255,255,1);
        position: relative;
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
        float: left;
    }

    .details p {
        display: inline-box;
        margin: 0;
        margin-top: 50px;
        margin-bottom: 10px;
        font-size: 60px;
        color: #58585b;
        font-weight: normal;
        float: right;
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

    div.images {
        margin-top: 20px;
        margin-bottom: 20px;
        width: 2240px;
        margin-left: 120px;
        margin-right: 120px;
        text-align: center;
    }

    div.images img {
        height: 950px;
        margin-left:15px ;
        margin-right:15px;
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
      margin: 0 auto;
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

                <div class="details">
                    <h1><?=$pupil->firstname?> <?=$pupil->secondname?></h1>
                    <p><?=$yearjoined?> - 2016 | <?=$pupil->house?></p>
                </div>

            </div>

            <hr>

            <div class="images">

                <img src="/photo_get.php?type=baby&rollnumber=<?=$pupil_rollnumber?>" style="text-align: left;">

                <img src="/photo_get.php?type=current&rollnumber=<?=$pupil_rollnumber?>" style="text-align: center;">
                <img src="/photo_get.php?type=school_photo&rollnumber=<?=$pupil_rollnumber?>" style="text-align: right;">

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