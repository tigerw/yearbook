<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    header( 'Location: index.php' ) ;
    exit;
}

require('templates/header.php');

if($_POST['update'] == "true") {
    $User->updateQuestions($_POST['first-question'], $_POST['first-answer'], $_POST['second-question'], $_POST['second-answer'], $_POST['year-joined']);
?>

    <div class="ui green inverted segment">Questions updated successfully</div>

<?php

}

?>

<div class="ui red segment">
    <h1>Answer two questions about yourself</h1>
</div>

<div class="ui segment">

    <form class="ui form" method="post">

        <div class="field">
            <label>First question...</label>
            <select class="ui dropdown" name="first-question">
            <option value="">Question</option>
            <?php

            $questions = DB::query("SELECT * FROM pupil_questions");

            foreach($questions as $question) {

                if($User->firstquestion == $question['id']) {
            ?>
                            <option value="<?=$question['id']?>" selected><?=$question['question']?>...</option>
            <?php

                }else {

            ?>
                            <option value="<?=$question['id']?>"><?=$question['question']?>...</option>
            <?php

                }

            }

            ?>

            </select>
        </div>

        <div class="field">
            <label>Answer</label>
            <input type="text" name="first-answer" placeholder="Answer" value="<?=$User->firstanswer?>" id="firstanswer">
            <p>Characters remaining: <span id="firstlimit"></span></p>
        </div>

        <div class="field">
            <label>Second question...</label>
            <select class="ui dropdown" name="second-question">
            <option value="">Question</option>
            <?php

            $questions = DB::query("SELECT * FROM pupil_questions");

            foreach($questions as $question) {

                if($User->secondquestion == $question['id']) {
            ?>
                            <option value="<?=$question['id']?>" selected><?=$question['question']?>...</option>
            <?php

                }else {

            ?>
                            <option value="<?=$question['id']?>"><?=$question['question']?>...</option>
            <?php

                }
                
            }

            ?>

            </select>
        </div>

        <div class="field">
            <label>Answer</label>
            <input type="text" name="second-answer" placeholder="Answer" value="<?=$User->secondanswer?>" id="secondanswer">
            <p>Characters remaining: <span id="secondlimit"></span></p>
        </div>

        <div class="field">
            <label>Year Joined (Year 0 is reception)</label>
            <select class="ui dropdown" name="year-joined">
                <option value="">Choose your starting year...</option>
                <?php
                for($x = 0; $x <= 12; $x++) {
                    if($x == $User->yearjoined) {
                ?>
                <option value="<?=$x?>" selected>Year <?=$x?></option>
                <?php
                    }else {
                ?>
                <option value="<?=$x?>">Year <?=$x?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
        <input type="hidden" name="update" value="true"/>
        <button class="ui positive button" type="submit">Save</button>
    </form>

</div>

<script>

(function($) {
    $.fn.extend( {
        limiter: function(limit, elem) {
            $(this).on("keyup focus", function() {
                setCount(this, elem);
            });
            function setCount(src, elem) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html( limit - chars );
            }
            setCount($(this)[0], elem);
        }
    });
})(jQuery);

$('select.dropdown')
  .dropdown()
;

$("#firstanswer").limiter(70, $("#firstlimit"));
$("#secondanswer").limiter(70, $("#secondlimit"));

</script>

<?php

require('templates/footer.php');

?>