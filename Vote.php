<?php

require_once '../Composer/vendor/autoload.php';
require_once 'Configuration.php';
require_once 'Controllers/Authenticator.php';

if (!Authenticator::IsLoggedIn())
{
	Redirect('/login');
	return;
}

$AddSuccess = true;
if (isset($_POST['AwardId']) && isset($_POST['CandidateStudentId']))
{
	try
	{
		$GLOBALS['YearbookModel']->LogAwardVote($_POST['AwardId'], $_POST['CandidateStudentId'], $_SESSION['StudentId']);
	}
	catch (MeekroDBException $DBException)
	{
		$AddSuccess = false;
	}
}

$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('Templates', 'Templates/Modules')), array('cache' => '../Cache', 'auto_reload' => true));
$Template->addFilter(
	new Twig_Filter(
		'AwardVotesAwardIdGroup',
		function ($AwardVotes)
		{
    		$AwardVoteGrouping = array();
			foreach ($AwardVotes as $AwardVote)
			{
				$AwardVoteGrouping[$AwardVote->Award->AwardId][] = $AwardVote;
			}
			
			return $AwardVoteGrouping;
		}
	)
);

$Template->display(
	'Vote.html',
	array(
		'TaskStates' => TaskState::GetTaskStates(), 
		'Students' => $GLOBALS['YearbookModel']->FindStudents(),
		'Awards' => $GLOBALS['YearbookModel']->FindApprovedAwards(),
		'AwardVotes' => $GLOBALS['YearbookModel']->FindAwardVotesByVotingStudentId($_SESSION['StudentId']),
		'OperationSuccessful' => $AddSuccess
	)
);