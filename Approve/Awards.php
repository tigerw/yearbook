<?php

require_once '../Configuration.php';
require_once '../../Composer/vendor/autoload.php';
require_once 'Controllers/Authenticator.php';

if (isset($_POST['AwardApprovals']))
{
	foreach ($_POST['AwardApprovals'] as $ApprovedAwardId)
	{
		$GLOBALS['YearbookModel']->ApproveAwardProposal($ApprovedAwardId);
	}
}

$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('../Templates', '../Templates/Modules', '../Templates/Approve')), array('cache' => '../../Cache', 'auto_reload' => true));
$Template->display(
	'Awards.html',
	array(
		'AwardProposals' => $GLOBALS['YearbookModel']->FindAwards()
	)
);
// e^3y=x^2+y
?>