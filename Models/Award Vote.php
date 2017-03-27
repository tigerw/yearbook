<?php
class AwardVote
{
	public function __construct($Record)
	{
		$this->VoteId = $Record['VoteId'];
		$this->VotingStudentId = $Record['VotingStudentId'];
		
		$this->CandidateStudent = new Student($Record);
		$this->Award = new Award($Record);
	}

	public $VoteId;
	public $VotingStudentId;
	
	public $CandidateStudent;
	public $Award;
}