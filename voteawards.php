<?php

require('app.php');

if(!PupilAuth::isLoggedIn()) {
    header( 'Location: index.php' ) ;
    exit;
}

require('templates/header.php');

?>        
        
            
            <div class="ui active dimmer">
                    <div class="ui loader"></div>
                </div>  

        <div class="ui red segment">
            <h1>Vote for awards</h1>
            <p>Nominate one pupil for each award. At the end, a winner will be announced for each award along with two runners up. You're allowed to nominate yourself.</p>
        </div>
            
        <table class="ui celled striped table awards_table">
            <thead>
                <tr>
                    <th class="ten wide">Awards</th>
                    <th class="six wide">Nominations</th>
                </tr>
            </thead>              
<?php

$awards = DB::query("SELECT * FROM awards");
$votes = DB::query("SELECT * FROM award_votes WHERE rollnumber = %i", $User->rollnumber);

foreach($awards as $award) {

?>
                
                <tr award_id="<?=$award["id"]?>">
                    <td class="dy_award_name"><?=$award['award']?></td>
                    <td class="dy_award_value negative">
                        
                        <div class="ui small search" style="float: left;"><div class="ui icon input"><input class="prompt" type="text" placeholder="Search students..."><i class="search icon"></i></div></div>
                        
                    </td>
                </tr>

<?php

}
    
?>
            
            </tbody>
        </table>
        <div class="ui segment">
            <div class="ui labeled button" tabindex="0">
                <a href="/" class="ui green button">
                    <i class="arrow left icon"></i> back
                </a>
                <a class="ui basic green left pointing label">
                    Autosaved
                </a>
            </div>
        </div>

<script>
    
    //Load awards pupil has voted on and update table
    $.getJSON( "/getcompletedawards.php", function( data ) {
        $('.dimmer').remove();
        $.each( data, function( key, val ) {
            $('tr[award_id="' + key + '"]').find("td.dy_award_value").removeClass("negative").addClass("positive").html('<p>' + val + ' <a href="javascript:editAward(' + key + ')">edit</a></p>');
        });
    });
    
    function updateAward(awardid, value) {
        $.get( "updateaward.php", { awardid: awardid, value: value} )
            .done(function( data ) {
                if(data != "success") {
                    alert("Error updating award, please refresh the page and try again");
                }
                $('tr[award_id="' + awardid + '"]').find('td.dy_award_value').html("<p>" + value + ' <a href="javascript:editAward(' + awardid + ')">edit</a></p>').removeClass("negative").addClass("positive");
        });
    }
    
    function editAward(awardid) {
        $('tr[award_id="' + awardid + '"]').find('td.dy_award_value').find('a').remove();
        $('tr[award_id="' + awardid + '"]').find('td.dy_award_value').html('<div class="ui small search" style="float: left;"><div class="ui icon input"><input class="prompt" type="text" placeholder="Search students..." value="' + $('tr[award_id="' + awardid + '"]').find('td.dy_award_value').text().slice(0,-1) + '"><i class="search icon"></i></div></div>').removeClass("positive").addClass("negative");
        $('.ui.search')
          .search({
            source: pupils,
            onSelect: function(response) {
                updateAward($(this).parent().parent().attr('award_id'), response.title);
            }
          })
        ;
    }
    
var pupils = [

<?php

foreach(Pupil::getAllPupilNames() as $pupil) {
    echo "{ title: '" . str_replace("'", "\\'", htmlspecialchars($pupil)) . "' },\n";
}

?>
    
];
    
$('.ui.search')
  .search({
    source: pupils,
    onSelect: function(response) {
        updateAward($(this).parent().parent().attr('award_id'), response.title);
    }
  })
;
</script>

<?php

require('templates/footer.php');

?>