<?php
require_once 'Libraries/MeekroDB.php';
require_once 'Models/Student.php';
require_once 'Models/Biography Entry.php';
require_once 'Models/Award Proposal.php';
require_once 'Models/Question Proposal.php';

class YearbookModel
{
	public function __construct()
	{
		$this->DB = new MeekroDB(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
		$this->DB->error_handler = false;
		$this->DB->throw_exception_on_error = true;
	}

	public function AddAwardProposal($StudentId, $Description)
	{
		$this->DB->insert('award proposals', array('StudentId' => $StudentId, 'Description' => $Description));
	}

	public function AddQuestionProposal($StudentId, $Question)
	{
		$this->DB->insert('question proposals', array('StudentId' => $StudentId, 'Question' => $Question));
	}
	
	public function AddBiographyEntry($AuthorStudentId, $TargetStudentId)
	{
		$this->DB->startTransaction();

        if (count($this->FindBiographiesByTargetStudentId($TargetStudentId)) == 5)
        {
            throw new MeekroDBException();
        }

		$this->DB->insert('biography entries', array('AuthorStudentId' => $AuthorStudentId, 'TargetStudentId' => $TargetStudentId));
		$this->DB->commit();
	}

	public function FindStudents()
	{
		$Records = $this->DB->query("SELECT * FROM students");
		return array_map(
			function($Record)
			{
				return new Student($Record);
			},
			$Records
		);
	}

	public function FindStudentById($StudentId)
	{
		$Record = $this->DB->queryFirstRow("SELECT * FROM students WHERE StudentId = %i", $StudentId);
		
		if ($Record === null)
		{
			return null;
		}

		return new Student($Record);
	}

	public function FindBiographiesByTargetStudentId($TargetStudentId)
	{
		$Records = $this->DB->query("SELECT * FROM `biography entries` WHERE TargetStudentId = %i", $TargetStudentId);
		return array_map(
			function($Record)
			{
				return new BiographyEntry($Record);
			},
			$Records
		);
	}

	public function FindBiographiesByAuthorStudentId($AuthorStudentId)
	{
		$Records = $this->DB->query("SELECT * FROM `biography entries` WHERE AuthorStudentId = %i", $AuthorStudentId);
		return array_map(
			function($Record)
			{
				return new BiographyEntry($Record);
			},
			$Records
		);
	}

	public function FindAwardProposals()
	{
		$Records = $this->DB->query("SELECT * FROM `award proposals`, `students` WHERE `award proposals`.StudentId = `students`.StudentId");
		return array_map(
			function($Record)
			{
				return new AwardProposal($Record);
			},
			$Records
		);
	}

	public function FindAwardProposalsByStudentId($StudentId)
	{
		$Records = $this->DB->query("SELECT * FROM `award proposals`, `students` WHERE `award proposals`.StudentId = %i AND `award proposals`.StudentId = `students`.StudentId", $StudentId);
		return array_map(
			function($Record)
			{
				return new AwardProposal($Record);
			},
			$Records
		);
	}

	public function FindQuestionProposals()
	{
		$Records = $this->DB->query("SELECT * FROM `question proposals`, `students` WHERE `question proposals`.StudentId = `students`.StudentId");
		return array_map(
			function($Record)
			{
				return new QuestionProposal($Record);
			},
			$Records
		);
	}

	public function FindQuestionProposalsByStudentId($StudentId)
	{
		$Records = $this->DB->query("SELECT * FROM `question proposals`, `students` WHERE `question proposals`.StudentId = %i AND `question proposals`.StudentId = `students`.StudentId", $StudentId);
		return array_map(
			function($Record)
			{
				return new QuestionProposal($Record);
			},
			$Records
		);
	}

	private $DB;
}