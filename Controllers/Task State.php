<?php
require_once 'Models/Task.php';

class TaskIds
{
	const Think = 0;
	const Question = 1;
	const Choose = 2;
	const Write = 3;
	const Vote = 4;
	const Answer = 5;
	const Photograph = 6;
}

class EnabledTaskState
{
	public function __construct($Task, $Completed)
	{
		$this->Task = $Task;
		$this->Completed = $Completed;
	}

	public $Task;
	public $Completed;
}

class DisabledTaskState
{
	public function __construct($Task)
	{
		$this->Task = $Task;
	}

	public $Task;
}

class TaskState
{
	public static function GetTaskStates()
	{
		$TaskStates = array();

		foreach (
			array(
				TaskIds::Think => new Task('/think', 'Come up with awards', Task::Complete),
				TaskIds::Question => new Task('/question', 'Come up with questions', Task::Complete),
				TaskIds::Choose => new Task('/choose', 'Choose people to author', Task::Complete),
				TaskIds::Write => new Task('/write', 'Write your entries', Task::Complete),
				TaskIds::Vote => new Task('/vote', 'Vote for awards', Task::Queued),
				TaskIds::Answer => new Task('/answer', 'Answer questions', Task::Queued),
				TaskIds::Photograph => new Task('/photograph', 'Add your profile photos', Task::Queued)
			) as $Key => $Task
		)
		{
			if (!$Task->Status === Task::Available)
			{
				$TaskStates[] = new DisabledTaskState($Task);
				continue;
			}
			$TaskStates[] = new EnabledTaskState($Task, self::GetTaskState($Key));
		}

		return $TaskStates;
	}

	private static function GetTaskState($Key)
	{
		switch ($Key)
		{
			case TaskIds::Think: return !empty($GLOBALS['YearbookModel']->FindAwardsByStudentId($_SESSION['StudentId']));
			case TaskIds::Question: return !empty($GLOBALS['YearbookModel']->FindQuestionsByStudentId($_SESSION['StudentId']));
			case TaskIds::Choose: return (count($GLOBALS['YearbookModel']->FindBiographiesByTargetStudentId($_SESSION['StudentId'])) === 5);
			case TaskIds::Vote: return !empty($GLOBALS['YearbookModel']->FindAwardVotesByVotingStudentId($_SESSION['StudentId']));
			default: return false;
		}
	}
}