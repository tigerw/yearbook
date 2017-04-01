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
if ($TaskStates[TaskIds::Write]->Task->Status != Task::Available)
{
	http_response_code(403);
	return;
}

$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('Templates', 'Templates/Modules')), array('cache' => '../Cache', 'auto_reload' => true));
if (isset($_GET['ParameterA']))
{
	$Biography = $GLOBALS['YearbookModel']->FindBiographyByAuthorTargetStudentIds($_SESSION['StudentId'], $_GET['ParameterA']);
	
	if ($Biography === null)
	{
		http_response_code(400);
		return;
	}
	
	if (isset($_POST['Content']) && isset($_POST['Signature']))
	{
		$Biography->Content = $_POST['Content'];
		$Biography->Signature = $_POST['Signature'];
		
		$GLOBALS['YearbookModel']->EditBiographyEntry($Biography);
	}
	
	$Template->display('Write.html', array('TaskStates' => $TaskStates, 'Biography' => $Biography));
}
else
{
	if (isset($_POST['TargetStudentChoiceId']))
	{
		Redirect('/write/' . $_POST['TargetStudentChoiceId']);
		return;
	}
	
	$Template->display('Write Choice.html', array('TaskStates' => $TaskStates, 'BiographyRequests' => $GLOBALS['YearbookModel']->FindBiographiesByAuthorStudentId($_SESSION['StudentId'])));
}