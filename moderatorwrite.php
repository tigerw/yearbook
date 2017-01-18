<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    header( 'Location: index.php' ) ;
    exit;
}

require('templates/header.php');

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
        <h1>Moderator Edit</h1>
    </div>

<?php

    $pupil_rn = $_GET['pupil'];
    $author_rn = $_GET['author'];
    $pupil_details = new Pupil();
    $pupil_details->setWithRollNumber($pupil_rn);
    $author = new Author($pupil_rn, $author_rn);
    $author->fetchDetails();

?>

    <div class="ui segment">

        <form action="/updatemoderate.php">
        <input type="hidden" name="action" value="edit"/>
        <input type="hidden" name="pupil" value="<?=$pupil_rn?>"/>
        <input type="hidden" name="author" value="<?=$author_rn?>"/>
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

require('templates/footer.php');

?>