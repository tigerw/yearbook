<?php

class Author {
    
    public $pupil_rollnumber;
    public $author_rollnumber;
    public $author_text;
    public $author_signature;
    public $activity;
    
    public function __construct($pupil, $author) {
        
        $this->pupil_rollnumber = $pupil;
        $this->author_rollnumber = $author;
        
    }
 
    public function check() {
        
        // Check if a pupil exists as an author for a defined pupil
        
        $query_test = DB::queryFirstRow("SELECT * FROM author_choices WHERE pupil_rollnumber=%i AND author_rollnumber=%i", $this->pupil_rollnumber, $this->author_rollnumber);
        
        if($query_test['author_rollnumber'] == $this->author_rollnumber) {
            
            return true;
            
        }else {
            
            return false;
        
        }
        
    }
    
    public function add() {
        
        // Add a pupil as an author
        
        $pupil = $this->pupil_rollnumber;
        $author = $this->author_rollnumber;
        
        // Validation Checks
        
        if($pupil == $author) {
            
            // Pupil cannot select self as author
            
            return false;
            
        }else if(!in_array($author, Pupil::getAllPupilRollNumbers())) {
            
            // Author must be pupil in database
            
            return false;
            
        }else if(in_array($author, self::getCurrentAuthors($pupil))) {
            
            // Pupil cannot already be an author
            
            return false;
            
        }else if(count(self::getCUrrentAuthors($pupil)) >= 5) {
            
            // Pupil cannot have more than 5 authors
            
            return false;
            
        }else {
            
            // Pupil is ok and database is updated
            
            DB::insert(
                'author_choices',
                array(
                    'pupil_rollnumber' => $pupil,
                    'author_rollnumber' => $author
                )
            );
            
            return true;
            
        }
        
        // DB insert
        
    }
    
    public function delete() {

        // Remove a pupil as an author
        
        DB::delete('author_choices', 'pupil_rollnumber=%i AND author_rollnumber=%i', $this->pupil_rollnumber, $this->author_rollnumber);
        
        return true;
        
    }

    public function fetchDetails() {

        $query = DB::queryFirstRow('SELECT * FROM author_choices WHERE pupil_rollnumber=%i AND author_rollnumber=%i', $this->pupil_rollnumber, $this->author_rollnumber);

        $this->author_text = $query['text'];
        $this->author_signature = $query['signature'];
        $this->activity = $query['activity'];

        return true;

    }

    public function editText($text) {

        DB::update('author_choices', array('text' => $text), 'pupil_rollnumber=%i AND author_rollnumber=%i', $this->pupil_rollnumber, $this->author_rollnumber);


    }

    public function editSignature($signature) {

        DB::update('author_choices', array('signature' => $signature), 'pupil_rollnumber=%i AND author_rollnumber=%i', $this->pupil_rollnumber, $this->author_rollnumber);


    }

    public function editStatus($status) {

        DB::update('author_choices', array('status' => $status), 'pupil_rollnumber=%i AND author_rollnumber=%i', $this->pupil_rollnumber, $this->author_rollnumber);

    }

    public function appendActivity($activity) {

        $this->fetchDetails();

        // change Joe's password
        DB::update('author_choices', array('activity' => $this->activity . "[" . date('d/m/Y H:i:s') . "] " . $activity . "\n\n"), 'pupil_rollnumber=%i AND author_rollnumber=%i', $this->pupil_rollnumber, $this->author_rollnumber);

    }
    
    public static function getCurrentAuthors($pupil) {
        
        $authors_query = DB::query("SELECT * FROM author_choices WHERE pupil_rollnumber=%i", $pupil);
        $authors = array();
        
        foreach($authors_query as $author) {
            array_push($authors, $author['author_rollnumber']);
        }
        
        return $authors;
        
    }

    public static function getPupilsByAuthor($author) {

        $pupils_query = DB::query("SELECT * FROM author_choices WHERE author_rollnumber=%i", $author);
        $pupils = array();
        
        foreach($pupils_query as $pupil) {
            array_push($pupils, $pupil['pupil_rollnumber']);
        }
        
        return $pupils;

    }
    
}