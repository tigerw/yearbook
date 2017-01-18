<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    header( 'Location: index.php' ) ;
    exit;
}

require('templates/header.php');

?>

<div class="ui red segment">
    <h1>Choose Your Authors</h1>
    <p>Enter the 5 people that you'd like to ask to author your yearbook entry. The 5 people will recieve a notification asking them to write a paragraph about you.</p>
</div>

<table class="ui celled striped table awards_table">
    <thead>
        <tr>
            <th>Pupil</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="authors">
        
<?php
        
    // Print existing authors
        
    $existing_authors = DB::query('SELECT * FROM author_choices WHERE pupil_rollnumber=%i', $User->rollnumber);
        
    $authorsstr = array();    
    
    if(count($existing_authors) == 0) {
        // Print no chosen pupils
        
?>
        <tr>
            <td colspan="2">You haven't chosen any pupils yet</td>
        </tr>      
<?php
        
    }else {
        
        foreach($existing_authors as $author) {
            $authorpupil = new Pupil();
            $authorpupil->setWithRollNumber($author['author_rollnumber']);
            $authorsstr[] = $authorpupil->firstname . " " . $authorpupil->secondname;
?>
        <tr>
            <td><?=$authorpupil->firstname . " " . $authorpupil->secondname?></td>
            <td><a href="#" class="remove_author">remove</a></td>
        </tr>
<?          
        }
        
    }
        
?>
    </tbody>
</table>

<div class="ui segment">

    <form class="ui form">
    
        <div class="ui small search">
            <div class="ui icon input">
                <input class="prompt" type="text" placeholder="Search students..." name="pupil" id="pupil_select"/>
                <i class="search icon"></i>
            </div>
        </div>
        
        <br/>
        
        <a class="ui positive button" id="add_pupil">Add Pupil</a>
    
    </form>    
    
</div>

<script>
    
var pupils = [

<?php

foreach(Pupil::getAllPupilNames() as $pupil) {
    echo "{ title: '" . str_replace("'", "\\'", htmlspecialchars($pupil)) . "' },\n";
}

?>
    
];
    
var pupils_basic = [

<?php

foreach(Pupil::getAllPupilNames() as $pupil) {
    echo "'" . str_replace("'", "\\'", htmlspecialchars($pupil)) . "',\n";
}

?>
    
];
    
var authors = [<?php
    foreach($authorsstr as $authorstr) {
        echo "'" . str_replace("'", "\\'", htmlspecialchars($authorstr)) . "',\n";
    }  
?>];
    
$("#add_pupil").click(function() {
        
    if($.inArray($("#pupil_select").val(), pupils_basic) == -1) {
        
        alert("Pupil not found");
        
    }else if(authors.length >=5) {
        
        alert("Max number of authors reached");
    
    }else if($("#pupil_select").val() == "<?php echo $User->firstname . " " . $User->secondname; ?>") {
    
        alert("You can't choose yourself as an author");
        
    }else if($.inArray($("#pupil_select").val(), authors) >= 0) {
        
        alert("Pupil already an author");
        
    }else {
        
        if(authors.length == 0) {
            $("#authors").html("");
        }
        
        var new_author = $("#pupil_select").val();
        
        $("#authors").html($("#authors").html() + '<tr><td>' + new_author + '</td><td><a href="#" class="remove_author">remove</a></td></tr>');
                
        $.get( "updateauthor.php", { author_name: new_author, request: 'add'} )
            .done(function( data ) {
                if(data != "success") {
                    alert("Error updating award, please refresh the page and try again");
                    
                    return;
                }
        });
        
        authors.push(new_author);
        
    }
    
});
    
/* NEED TO DYNAMICALLY HOOK ONTO CLICK() */
    
$(document).on("click", ".remove_author", function(event) {
    
    author = $(this).parent().prev().text();
    
    pupilobj = $(this);
            
    $.get( "updateauthor.php", { author_name: author, request: 'delete'} )
        .done(function( data ) {
            if(data != "success") {
                alert("Error updating award, please refresh the page and try again");
                return;
            }
        
        authors.splice(authors.indexOf(author), 1);
        
        pupilobj.parent().parent().remove();
    
    });
    
});

$('.ui.search')
  .search({
    source: pupils,
    onSelect: function(response) {
    }
  })
;
    
</script>

<?php

require('templates/footer.php');

?>