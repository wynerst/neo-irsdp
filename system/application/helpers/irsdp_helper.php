<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function nice_date($date)
{
	$delimiter = '/';
	
	if($date!="")
	{
		list($year, $month, $day) = explode('-', $date);
		return $day."".$delimiter."".$month."".$delimiter."".$year;	
	}
	else 
		return "-";
}

function short_date($date)
{	
	if($date!="")
	{
		list($year, $month, $day) = explode('-', $date);
		return date("M-y", mktime(0, 0, 0, $day, $month, $year));
		//return short_month($month)."-".substr($year,2,-2);	
	}
	else 
		return "-";	
}

function form_checklist($stat)
{
	if($stat==1)
		return "&#10003";
	else 
		return "-";	
}

function percentage($num_amount, $num_total) 
{
	$count = ($num_amount / $num_total)*100;
	$count = number_format($count, 1);
	return $count;
}

/* End of file irdsp_helper.php */
/* Location: ./system/application/helpers/irdsp_helper.php */