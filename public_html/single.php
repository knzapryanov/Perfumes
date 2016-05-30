<?php
session_start();
include "template.class.php";

$template = new Template;
$template->load("template.html");
$template->replace("MAIN_CONTENT_TITLE", "");
$template->replace("MAIN_CONTENT",file_get_contents('single.html'));
$template->publish();

?>