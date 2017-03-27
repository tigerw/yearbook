<?php
require_once 'Libraries/MeekroDB.php';
require_once 'Models/Student.php';
require_once 'Models/Biography Entry.php';
require_once 'Models/Award.php';
require_once 'Models/Award Vote.php';
require_once 'Models/Question.php';

class YearbookModel
{
	public function __construct()
	{
		$this->DB = new MeekroDB(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME, 3306, 'utf8mb4');
		$this->DB->error_handler = false;
		$this->DB->throw_exception_on_error = true;
	}

	public function AddAwardProposal($StudentId, $Description)
	{
		$this->DB->insert('awards', array('StudentId' => $StudentId, 'Description' => $Description));
	}

	public function AddQuestionProposal($StudentId, $Question)
	{
		$this->DB->insert('questions', array('StudentId' => $StudentId, 'Question' => $Question));
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

	public function ApproveAwardProposal($AwardId)
	{
		$this->DB->update('awards', array('Approved' => true), 'AwardId = %i', $AwardId);
	}
	
	public function LogAwardVote($AwardId, $CandidateStudentId, $VotingStudentId)
	{
		$this->DB->startTransaction();
		
        /*if (count($this->FindAwardVotesByAwardId($AwardId)) == 1)
        {
            throw new MeekroDBException();
        }*/
		
		$this->DB->insert('award votes', array('AwardId' => $AwardId, 'CandidateStudentId' => $CandidateStudentId, 'VotingStudentId' => $VotingStudentId));
		$this->DB->commit();
	}

	public function ApproveQuestionProposal($QuestionId)
	{
		$this->DB->update('questions', array('Approved' => true), 'QuestionId = %i', $QuestionId);
	}
	
	public function EditBiographyEntry($Biography)
	{
		$this->DB->update('biography entries', array('Content' => $Biography->Content, 'Signature' => $Biography->Signature), 'EntryId = %i', $Biography->EntryId);
	}
	
	public function RemoveBiographyEntry($TargetStudentId, $EntryId)
	{
		// TargetStudentId is used for verification of ownership of an entry. Not great and very confusing, but easiest :/
		
		$this->DB->delete('biography entries', 'TargetStudentId = %i AND EntryId = %i', $TargetStudentId, $EntryId);
	}

	public function FindStudents()
	{
		$Records = $this->DB->query('SELECT * FROM students');
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
		$Record = $this->DB->queryFirstRow('SELECT * FROM students WHERE StudentId = %i', $StudentId);
		
		if ($Record === null)
		{
			return null;
		}

		return new Student($Record);
	}

	public function FindBiographies()
	{
		$Records = $this->DB->query(
			'SELECT
				BE.EntryId, BE.Content, BE.Signature,
				S1.StudentId AS TargetStudentId, S1.Forename AS TargetForename, S1.Surname AS TargetSurname, S1.TutorGroup AS TargetTutorGroup, S1.House AS TargetHouse, S1.YearJoined AS TargetYearJoined,
				S2.StudentId AS AuthorStudentId, S2.Forename AS AuthorForename, S2.Surname AS AuthorSurname, S2.TutorGroup AS AuthorTutorGroup, S2.House AS AuthorHouse, S2.YearJoined AS AuthorYearJoined
			FROM `biography entries` as BE
				JOIN `students` AS S1 ON BE.TargetStudentId = S1.StudentId
				JOIN `students` AS S2 ON Be.AuthorStudentId = S2.StudentId
			'
		);
		return array_map(
			function($Record)
			{
				return new BiographyEntry($Record);
			},
			$Records
		);
	}

	public function FindBiographyByAuthorTargetStudentIds($AuthorStudentId, $TargetStudentId)
	{
		// Assume that a given Author and Target identifier will uniquely map to one entry
		$Entry = $this->DB->queryFirstRow(
			'SELECT
				BE.EntryId, BE.Content, BE.Signature,
				S1.StudentId AS TargetStudentId, S1.Forename AS TargetForename, S1.Surname AS TargetSurname, S1.TutorGroup AS TargetTutorGroup, S1.House AS TargetHouse, S1.YearJoined AS TargetYearJoined,
				S2.StudentId AS AuthorStudentId, S2.Forename AS AuthorForename, S2.Surname AS AuthorSurname, S2.TutorGroup AS AuthorTutorGroup, S2.House AS AuthorHouse, S2.YearJoined AS AuthorYearJoined
			FROM `biography entries` as BE
				JOIN `students` AS S1 ON BE.TargetStudentId = S1.StudentId
				JOIN `students` AS S2 ON Be.AuthorStudentId = S2.StudentId
			WHERE
				BE.AuthorStudentId = %i AND
				BE.TargetStudentId = %i',
			$AuthorStudentId,
			$TargetStudentId
		);
		
		if ($Entry === null)
		{
			return null;
		}
		
		return new BiographyEntry($Entry);
	}

	public function FindBiographiesByTargetStudentId($TargetStudentId)
	{
		$Records = $this->DB->query(
			'SELECT
				BE.EntryId, BE.Content, BE.Signature,
				S1.StudentId AS TargetStudentId, S1.Forename AS TargetForename, S1.Surname AS TargetSurname, S1.TutorGroup AS TargetTutorGroup, S1.House AS TargetHouse, S1.YearJoined AS TargetYearJoined,
				S2.StudentId AS AuthorStudentId, S2.Forename AS AuthorForename, S2.Surname AS AuthorSurname, S2.TutorGroup AS AuthorTutorGroup, S2.House AS AuthorHouse, S2.YearJoined AS AuthorYearJoined
			FROM `biography entries` as BE
				JOIN `students` AS S1 ON BE.TargetStudentId = S1.StudentId
				JOIN `students` AS S2 ON Be.AuthorStudentId = S2.StudentId
			WHERE BE.TargetStudentId = %i',
			$TargetStudentId
		);
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
		$Records = $this->DB->query(
			'SELECT
				BE.EntryId, BE.Content, BE.Signature,
				S1.StudentId AS TargetStudentId, S1.Forename AS TargetForename, S1.Surname AS TargetSurname, S1.TutorGroup AS TargetTutorGroup, S1.House AS TargetHouse, S1.YearJoined AS TargetYearJoined,
				S2.StudentId AS AuthorStudentId, S2.Forename AS AuthorForename, S2.Surname AS AuthorSurname, S2.TutorGroup AS AuthorTutorGroup, S2.House AS AuthorHouse, S2.YearJoined AS AuthorYearJoined
			FROM `biography entries` as BE
				JOIN `students` AS S1 ON BE.TargetStudentId = S1.StudentId
				JOIN `students` AS S2 ON Be.AuthorStudentId = S2.StudentId
			WHERE BE.AuthorStudentId = %i',
			$AuthorStudentId
		);
		return array_map(
			function($Record)
			{
				return new BiographyEntry($Record);
			},
			$Records
		);
	}

	public function FindAwards()
	{
		$Records = $this->DB->query('SELECT * FROM `awards`, `students` WHERE `awards`.StudentId = `students`.StudentId');
		return array_map(
			function($Record)
			{
				return new Award($Record);
			},
			$Records
		);
	}
	
	public function FindAwardVotesByVotingStudentId($VotingStudentId)
	{
		$Records = $this->DB->query(
			'SELECT *
			FROM `award votes`, `students`, `awards`
			WHERE `award votes`.CandidateStudentId = `students`.StudentId AND `awards`.AwardId = `award votes`.AwardId AND `award votes`.VotingStudentId = %i',
			$VotingStudentId
		);
		return array_map(
			function($Record)
			{
				return new AwardVote($Record);
			},
			$Records
		);
	}

	public function FindApprovedAwards()
	{
		$Records = $this->DB->query('SELECT * FROM `awards`, `students` WHERE `awards`.StudentId = `students`.StudentId AND Approved = TRUE');
		return array_map(
			function($Record)
			{
				return new Award($Record);
			},
			$Records
		);
	}

	public function FindAwardsByStudentId($StudentId)
	{
		$Records = $this->DB->query('SELECT * FROM `awards`, `students` WHERE `awards`.StudentId = %i AND `awards`.StudentId = `students`.StudentId', $StudentId);
		return array_map(
			function($Record)
			{
				return new Award($Record);
			},
			$Records
		);
	}

	public function FindQuestions()
	{
		$Records = $this->DB->query('SELECT * FROM `questions`, `students` WHERE `questions`.StudentId = `students`.StudentId');
		return array_map(
			function($Record)
			{
				return new Question($Record);
			},
			$Records
		);
	}

	public function FindQuestionsByStudentId($StudentId)
	{
		$Records = $this->DB->query('SELECT * FROM `questions`, `students` WHERE `questions`.StudentId = %i AND `questions`.StudentId = `students`.StudentId', $StudentId);
		return array_map(
			function($Record)
			{
				return new Question($Record);
			},
			$Records
		);
	}

	private $DB;
}