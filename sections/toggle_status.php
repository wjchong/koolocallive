<?php

if(isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];
	include_once('php/Section.php');
	$sectionObj = new Section($conn);
    if($sectionObj->toggleStatus($id)) {
        redirect($site_url.'/sections.php?success=Section status has been changed.');
        exit;
    }
    redirect($site_url.'/sections.php?error=Section status could not be change. Please try again.');
    exit;
	
}
redirect($site_url.'/sections.php');
exit;