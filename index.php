<?php

$remove_sidebar = true;

require('app.php');

if(PupilAuth::isLoggedIn()) {
    header( 'Location: home.php' ) ;
    exit;
}

require('templates/header.php');

?>

    <div class="five column centered row">
        <div class="five wide column">
            
            <?php if(isset($_GET['failure']) && $_GET['failure'] == 1) { ?>
                
            <div class="ui red inverted segment">Login details incorrect. Please try again.</div>

            <?php } ?>
            
            <div class="ui red segment">

                <img src="/images/alleyns_logo.png" style="width: 60%; margin-left: 20%;"/>
                
                <div class="ui red inverted segment">
                <div class="ui red inverted form">
                    <form action="/performlogin.php">
                        <p>Uniware Card Number</p>
                        <div class="field">
                            <input type="text" name="recordnumber" placeholder="Uniware Card Number">
                        </div>
                        <p>Date of Birth</p>
                        <div class="three fields" method="get">
                            <div class="field">
                                <input type="text" placeholder="DD" maxlength="2" name="dobdd">
                            </div>
                            <div class="field">
                                <input type="text" placeholder="MM" maxlength="2" name="dobmm">
                            </div>
                            <div class="field">
                                <input type="text" placeholder="YY" maxlength="2" name="dobyy">
                            </div>
                        </div>


                        <input type="submit" value="Login" class="ui white inverted button">

                        </div>
                        </div>
                    </div>
                
                
            </div>
        </div>
    </div>

<?php

require('templates/footer.php');

?>