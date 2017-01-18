<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    header( 'Location: index.php' ) ;
    exit;
}

require('templates/header.php');

?>        
        <div class="ui red segment">
            <h1>Alleyn's Leavers Yearbook 2016</h1>
            <p>This year we've simplified the task of collecting everyone's information for the Yearbook and are using this online platform. To make this really easy for the team organising the yearbook make sure you submit all the relevant sections by the stated deadlines, otherwise you're just making work for other people. The award <i>'Least likely to succeed in anything'</i> will go to the last pupil to submit their yearbook.</p>
        </div>

        <div class="ui inverted teal segment">
            <h1>It's basically all done</h1>
            <p>Make sure the photos are uploaded and the questions are answered and that's all that needs doing. An online version of the yearbook will be made available soon.</p>
        </div>
        
        <div class="ui segment">
            <h3>Who am I writing for?</h3>
            <table class="ui table">
<?php

$pupilsWritingFor = Author::getPupilsByAuthor($User->rollnumber);

if(count($pupilsWritingFor) > 0) {
    foreach($pupilsWritingFor as $pupil) {
?>
            <tr><td><?=Pupil::getPupilNameByRollnumber($pupil)?></td></tr>
<?php
    }
}else {
?>
    <tr><td>No one has chosen you yet, but fear not. Many people choose to have more than one person write a single entry on their yearbook page and you may be asked to write something later on.</td></tr>
<?php
}

?>
        </table>
        </div>

        <div class="ui segment">
            <h3>How does this work?</h3>
            <p>The menu on the left shows which sections of your yearbook still need to be done. Anything in <span class="ui green horizontal label">green</span> is finalized and requires no further attention. Anything in <span class="ui orange horizontal label">orange</span> is pending and you should fill these sections out ASAP. Anything <span class="ui grey horizontal label">grey</span> will need to be filled out in the future, but not right now so you can ignore those and chill.<br/></br/>Once a section is completed it will change from orange to green. When a new section becomes available to fill in you'll hear about it on the facebook group or on the hub. If you're unsure what you need to do ask one of the team.</p>
        </div>

        <div class="ui segment">
            <h3>Still don't get it, help</h3>
            <p>Ask Oscar Deal, Ben TD, Annabel Hewitson, Ruby Welton or Vera Vorobyeva if you need help. If none of them have the answers speak to Ken.</p>
        </div>

<?php

require('templates/footer.php');

?>