<?php

class Student
{
	public $StudentId;
	public $Forename;
	public $Surname;
	public $DateOfBirth;
	public $TutorGroup;
	public $House;
	public $YearJoined;
	
	public function __construct($Record)
	{
		$this->StudentId = $Record['StudentId'];
		$this->Forename = $Record['Forename'];
		$this->Surname = $Record['Surname'];
		$this->TutorGroup = $Record['TutorGroup'];
		$this->House = $Record['House'];
		$this->YearJoined = $Record['YearJoined'];
	}

	public function updateQuestions($firstquestion, $firstanswer, $secondquestion, $secondanswer, $yearjoined) {

		DB::update('pupils', array("first_question" => $firstquestion, "first_answer" => $firstanswer, "second_question" => $secondquestion, "second_answer" => $secondanswer, "yearjoined" => $yearjoined), 'rollnumber=%i', $this->rollnumber);

		$this->setWithRollNumber($this->rollnumber);

		return true;

	}

	public static function getQuestion($id) {
		$query = DB::queryFirstRow("SELECT * FROM pupil_questions WHERE id=%i", $id);
		return $query['question'];
	}
	
	public static function getAllPupilNames() {
		$allrecords = DB::query("SELECT * FROM pupils");
		$pupils = array();
		foreach($allrecords as $record) {
			array_push($pupils, ($record['firstname'] . " " . $record['secondname']));
		}
		return $pupils;
	}
	
	public static function getAllPupilRollNumbers() {
		$allrecords = DB::query("SELECT * FROM pupils");
		$pupil_rollnumbers = array();
		foreach($allrecords as $record) {
			array_push($pupil_rollnumbers, ($record['rollnumber']));
		}
		return $pupil_rollnumbers;
	}
	
	public static function getPupilRollNumberFromName($name) {
		$name_split = explode(' ', $name, 2);
		$query = DB::queryFirstRow('SELECT rollnumber FROM pupils WHERE firstname=%s AND secondname=%s', $name_split[0], $name_split[1]);
		return $query['rollnumber'];
	}
	
	public static function getPupilNameByRollnumber($rollnumber) {
		$query = DB::queryFirstRow('SELECT * FROM pupils WHERE rollnumber=%i', $rollnumber);
		return $query['firstname'] . ' ' . $query['secondname'];
	}

	public static function getPupilNameArray() {

		$output = array();
		$query = DB::query('SELECT * FROM pupils ORDER BY secondname');
		foreach($query as $pupil) {
			$output[$pupil['rollnumber']] = $pupil['firstname'] . " " . $pupil['secondname'];
		}
		return $output;

	}

}