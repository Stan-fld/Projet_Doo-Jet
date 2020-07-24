<?php
session_start();

include_once("mvc/starter.php");

$page = new Page;

$page-> afficherPage();