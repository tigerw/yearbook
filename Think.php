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
if ($TaskStates[TaskIds::Think]->Task->Status != Task::Available)
{
	http_response_code(403);
	return;
}

if (isset($_POST['Description']))
{
	$GLOBALS['YearbookModel']->AddAwardProposal($_SESSION['StudentId'], $_POST['Description']);
}

$Proposals = $GLOBALS['YearbookModel']->FindAwardsByStudentId($_SESSION['StudentId']);
$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('Templates', 'Templates/Modules')), array('cache' => '../Cache', 'auto_reload' => true));
$Template->display('Think.html', array('TaskStates' => $TaskStates, 'Proposals' => $Proposals));