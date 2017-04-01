<?php

require_once '../Composer/vendor/autoload.php';
require_once 'Configuration.php';
require_once 'Controllers/Authenticator.php';

if (!Authenticator::IsLoggedIn())
{
	Redirect('/login');
	return;
}

$TaskStates = TaskState::GetTaskStates();
if ($TaskStates[TaskIds::Question]->Task->Status != Task::Available)
{
	http_response_code(403);
	return;
}

if (isset($_POST['Question']))
{
	$GLOBALS['YearbookModel']->AddQuestionProposal($_SESSION['StudentId'], $_POST['Question']);
}

$Proposals = $GLOBALS['YearbookModel']->FindQuestionsByStudentId($_SESSION['StudentId']);
$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('Templates', 'Templates/Modules')), array('cache' => '../Cache', 'auto_reload' => true));
$Template->display('Question.html', array('TaskStates' => $TaskStates, 'Proposals' => $Proposals));