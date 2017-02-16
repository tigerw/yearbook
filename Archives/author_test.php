<?php

require('app.php');

$author = new Author($User->rollnumber, 9039);

if($author->delete()) {
    echo "true";
}else {
    echo "false";
}