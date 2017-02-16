<?php
class AwardProposal
{
	public function __construct($Record)
	{
		$this->ProposalId = $Record['ProposalId'];
		$this->StudentId = $Record['StudentId'];
		$this->Description = $Record['Description'];
		
		$this->Student = new Student($Record);
	}

	public $ProposalId;
	public $StudentId;
	public $Description;
	
	public $Student;
}