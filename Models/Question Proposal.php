<?php
class QuestionProposal
{
	public function __construct($Record)
	{
		$this->ProposalId = $Record['ProposalId'];
		$this->StudentId = $Record['StudentId'];
		$this->Question = $Record['Question'];
		
		$this->Student = new Student($Record);
	}

	public $ProposalId;
	public $StudentId;
	public $Question;
	
	public $Student;
}