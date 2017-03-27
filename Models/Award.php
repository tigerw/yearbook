<?php
class Award
{
	public function __construct($Record)
	{
		$this->AwardId = $Record['AwardId'];
		$this->Description = $Record['Description'];
		$this->Approved = $Record['Approved'];
		
		$this->Student = new Student($Record);
	}

	public $AwardId;
	public $Description;
	public $Approved;
	
	public $Student;
}