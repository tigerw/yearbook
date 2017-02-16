<?php

class PupilAuth {

    public static function performLogin($pupilrolenumber, $pupildobstr) {
        if(self::isLoggedIn()) { # Check nobody is already logged in
            return array("failure", "User already logged in");   
        }
        
        $checkrecords = DB::queryFirstRow("SELECT * FROM pupils WHERE rollnumber = %i", $pupilrolenumber);

        if($checkrecords['dateofbirth'] == $pupildobstr) {
            self::makeLoginSession($pupilrolenumber);
            return array("success");  
        }else {
            return array("failure", "Incorrect login details");   
        }
    }
    
    public static function makeLoginSession($pupilrolenumber) {
        $_SESSION['pupilloggedin'] = true;
        $_SESSION['pupilrolenumber'] = $pupilrolenumber;
        $_SESSION['pupilauth'] = md5('AlleynsYearbook2K15!' . $pupilrolenumber);
    }
        
    
    public static function isLoggedIn() {
        if(
            array_key_exists('pupilloggedin', $_SESSION) && $_SESSION['pupilloggedin'] == true &&               # Check login vars set
            array_key_exists('pupilrolenumber', $_SESSION) && is_numeric($_SESSION['pupilrolenumber']) &&    # Check pupil number defined
            array_key_exists('pupilauth', $_SESSION) && $_SESSION['pupilauth'] == md5('AlleynsYearbook2K15!' . $_SESSION['pupilrolenumber'])
        ) {
            return true;   
        }else {
            return false;   
        }
    }
    
    public static function userFirstName() {
        if(self::isLoggedIn()) {
            $search = DB::queryFirstRow("SELECT firstname FROM pupils WHERE rollnumber = %i", $_SESSION['pupilrolenumber']);
            return $search['firstname'];
        }
    }
    
    public static function userSecondName() {
        if(self::isLoggedIn()) {
            $search = DB::queryFirstRow("SELECT secondname FROM pupils WHERE rollnumber = %i", $_SESSION['pupilrolenumber']);
            return $search['secondname'];
        }
    }
    
}