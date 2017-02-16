<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    header( 'Location: index.php' ) ;
    exit;
}

require('templates/header.php');

$pupils = Author::getPupilsByAuthor($User->rollnumber);

?>        

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

</script>

<style>
textarea::selection {
  background: #ffff99;
}
</style>

    <div class="ui segment">
        <h1>Write</h1>
        <p>You've got 700 chars per yeabrook entry including spaces, newlines and punctuation. 30 characters has been assigned to the signature, <i>"From Donald Trump"</i> or if you have multiple people coauthoring a yearbook entry you could change this to be <i>"From Donald and Hillary"</i>.<br/>Remember to hit save every now and then, i'd write your entries out on word and paste them in for safety.<br/><b>We need these in by February 26th</b></p>
    </div>

<?php

    foreach($pupils as $pupil) {

        $pupil_details = new Pupil();
        $pupil_details->setWithRollNumber($pupil);
        $author = new Author($pupil, $User->rollnumber);
        $author->fetchDetails();

?>

    <div class="ui segment">

        <form action="/updatewrite.php">
        <input type="hidden" name="pupil" value="<?=$pupil?>"/>
        <div class="ui header"><?=$pupil_details->firstname?> <?=$pupil_details->secondname?></div>
        <div class="ui form">
            <div class="field">
                <label>Writing</label>
                <textarea id="writing_<?=$pupil?>_textarea" name="text"><?=$author->author_text?></textarea>
                <p>Characters remaining: <span id="writing_<?=$pupil?>_limit"></span></p>
            </div>
            <div class="field">
                <label>Signature</label>
                <textarea rows="2" id="signature_<?=$pupil?>_textarea" name="signature" placeholder="Example: All the best, from Donald Trump"><?=$author->author_signature?></textarea>
                <p>Characters remaining: <span id="signature_<?=$pupil?>_limit"></span></p>
            </div>
            <input type="submit" class="ui positive button" value="Save"/>
            <br/><br/>
            <div class="field error">
                <label>Activity log</label>
                <textarea rows="2" readonly><?=$author->activity?></textarea>
            </div>
        </div>
        </form>

    </div>

<script>

$("#writing_<?=$pupil?>_textarea").limiter(700, $("#writing_<?=$pupil?>_limit"));
$("#signature_<?=$pupil?>_textarea").limiter(30, $("#signature_<?=$pupil?>_limit"));

</script>

<?php
    
    }

?>

<?php

require('templates/footer.php');

?>