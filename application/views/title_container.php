<?php 
	$title = "";
	if($this->uri->segment(2) == "" || $this->uri->segment(2) == "home")
		$title = "Home";
	else if($this->uri->segment(2) == "userList")
		$title = "List of Users";
	else if($this->uri->segment(2) == "client")
		$title = "List of Clients";
	else if($this->uri->segment(2) == "addClient")
		$title = "Add new client";
	else if($this->uri->segment(2) == "editClient")
		$title = "Update Client";
	else if($this->uri->segment(2) == "targetsAndActuals")
		$title = "Targets and Actuals";
	else if($this->uri->segment(2) == "userModules")
		$title = "User Modules";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SSG | <?php echo $title; ?></title>