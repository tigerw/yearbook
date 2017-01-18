<?php

require('app.php');

if(
    array_key_exists('recordnumber', $_GET) &&
    array_key_exists('dobdd', $_GET) &&
    array_key_exists('dobmm', $_GET) &&
    array_key_exists('dobyy', $_GET)
) {
    
    $recordnumber = $_GET['recordnumber'];
    $dobstr = $_GET['dobdd'] . "/" . $_GET['dobmm'] . "/" . $_GET['dobyy'];

    $authResult = PupilAuth::performLogin($recordnumber, $dobstr);

    if($authResult[0] == "success") {
        
        //Redirect to homepage
            
        header( 'Location: home.php' ) ;
        
        exit;
    }else {
        
        //Login failed
        
        if($authResult[1] == "User already logged in") {
            
            //Redirect to homepage
            
            header( 'Location: home.php' ) ;
            
        }
        
        header( 'Location: index.php?failure=1' ) ;
        
        exit;
    }
    
}else {
    
    // Login submission was incorrect
    
    header( 'Location: index.php?failure=1' ) ;

    
    exit;
}