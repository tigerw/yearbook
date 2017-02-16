<?php
require_once 'Models/Task.php';

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
				new Task('/think', 'Come up with awards', true),
				new Task('/question', 'Come up with questions', true),
				new Task('/choose', 'Choose 5 people to author', true),
				new Task('/vote', 'Vote for awards', false),
				new Task('/write', 'Write your entries', false),
				new Task('/photograph', 'Add your profile photos', false),
				new Task('/answer', 'Answer questions', false)
			) as $Key => $Task
		)
		{
			if (!$Task->Enabled)
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
			case 0: return !empty($GLOBALS['YearbookModel']->FindAwardProposalsByStudentId($_SESSION['StudentId']));
			case 1: return !empty($GLOBALS['YearbookModel']->FindQuestionProposalsByStudentId($_SESSION['StudentId']));
			case 2: return (count($GLOBALS['YearbookModel']->FindBiographiesByTargetStudentId($_SESSION['StudentId'])) === 5);
			default: return false;
		}
	}
}