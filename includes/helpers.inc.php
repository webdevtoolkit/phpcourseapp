<?php

function html($text)
{
  return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text)
{
  echo html($text);
}

function pageStatus()
{
	$status[0] = "Not resolved";
	$status[1] = "In Progress";
	$status[2] = "Resolved";
	
	return $status;	
}
