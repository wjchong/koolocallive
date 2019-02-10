<?php

$method = isset($_POST['_method']) ? $_POST['_method'] : null;

if(strtolower($method) == 'delete') {
	$id = $_POST['id'];
	include_once('php/Section.php');
	$sectionObj = new Section($conn);
    if($sectionObj->delete($id)) {
        redirect($site_url.'/sections.php?success=Section delete successfully.');
        exit;
    }
    redirect($site_url.'/sections.php?error=Section could not be deleted. Please try again.');
    exit;
	
}
redirect($site_url.'/sections.php');
exit;