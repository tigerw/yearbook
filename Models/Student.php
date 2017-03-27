<?php
class Student
{
	public $StudentId;
	public $Forename;
	public $Surname;
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
}