<?php

require_once '../Composer/vendor/autoload.php';
require_once 'Configuration.php';
require_once 'Controllers/Authenticator.php';

$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('Templates', 'Templates/Modules')), array('cache' => '../Cache', 'auto_reload' => true));
$Template->display(
	'Approve.html',
	array(
		'AwardProposals' => $GLOBALS['YearbookModel']->FindAwardProposals(),
		'QuestionProposals' => $GLOBALS['YearbookModel']->FindQuestionProposals()
	)
);
// e^3y=x^2+y
?>