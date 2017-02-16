<?php

require_once '../Composer/vendor/autoload.php';
require_once 'Configuration.php';
require_once 'Controllers/Authenticator.php';

if (!Authenticator::IsLoggedIn())
{
	Redirect('/login');
	return;
}

if (isset($_POST['Question']))
{
	$GLOBALS['YearbookModel']->AddQuestionProposal($_SESSION['StudentId'], $_POST['Question']);
}

$Proposals = $GLOBALS['YearbookModel']->FindQuestionProposalsByStudentId($_SESSION['StudentId']);
$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('Templates', 'Templates/Modules')), array('cache' => '../Cache', 'auto_reload' => true));
$Template->display('Question.html', array('TaskStates' => TaskState::GetTaskStates(), 'Proposals' => $Proposals));