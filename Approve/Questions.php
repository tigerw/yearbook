<?php

require_once '../Configuration.php';
require_once '../../Composer/vendor/autoload.php';
require_once 'Controllers/Authenticator.php';

if (isset($_POST['QuestionApprovals']))
{
	foreach ($_POST['QuestionApprovals'] as $ApprovedQuestionId)
	{
		$GLOBALS['YearbookModel']->ApproveQuestionProposal($ApprovedQuestionId);
	}
}

$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('../Templates', '../Templates/Modules', '../Templates/Approve')), array('cache' => '../../Cache', 'auto_reload' => true));
$Template->display(
	'Questions.html',
	array(
		'QuestionProposals' => $GLOBALS['YearbookModel']->FindQuestions()
	)
);
?>