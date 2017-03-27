<?php
class Question
{
	public function __construct($Record)
	{
		$this->QuestionId = $Record['QuestionId'];
		$this->Question = $Record['Question'];
		$this->Approved = $Record['Approved'];
		
		$this->Student = new Student($Record);
	}

	public $QuestionId;
	public $Question;
	public $Approved;
	
	public $Student;
}