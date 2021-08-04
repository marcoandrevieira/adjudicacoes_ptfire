<?php
function dateTime(){
	return date("Y-m-d H:i:s");
	}
	
function data(){
	return date("Y-m-d");
	}

function mes_corrente(){
	return date("m");	
	}

function ano_corrente(){
	return date("Y");	
	}	

function dates_from_range($start, $end, $meses) {
$interval = new DateInterval('P'.$meses.'M');
							
		$realEnd = new DateTime($end);
		$realEnd->add($interval);
							
		$period = new DatePeriod(
			new DateTime($start),
			$interval,
			$realEnd
		);
		$array=array();			
		foreach($period as $date) {
			
		
			 
				$array[] = $date->format('Y-m-d'); 
		
		}
		return $array;
	}
function dates_from_range_filtro($start, $end, $meses) {
	$interval = new DateInterval('P'.$meses.'M');
						
	$realEnd = new DateTime($end);
	$realEnd->add($interval);
						
	$period = new DatePeriod(
		new DateTime($start),
		$interval,
		$realEnd
	);
	$atual = date("Ym", strtotime($end));
	$data=NULL;					
	foreach($period as $date) {
		
		$nova = date("Ym", strtotime($date->format('Y-m-d')));;
		
		if($atual == $nova){
		 
			$data = $date->format('Y-m-d');
			//break; 
		}
	}
    return $data;
}	

function add_months_year($date, $meses){
	
	$date = date('Y', strtotime($date . "+{$meses} months") );
	
	return $date;
	
	}

function convert_timestamp($timestamp, $datetimeFormat){
	
	$date = new \DateTime();
	$date->setTimestamp($timestamp);
	echo $date->format($datetimeFormat);
	

}


function getWorkdays($date1, $date2, $workSat = FALSE, $patron = NULL) {
	//if (!defined('SATURDAY')) define('SATURDAY', 6);
	//if (!defined('SUNDAY')) define('SUNDAY', 0);
	$saturday=6;
	$sunday=0;
	$publicHolidays=array();
	// Array of all public festivities
	//$publicHolidays = array('01-01', '01-06', '04-25', '05-01', '06-02', '08-15', '11-01', '12-08', '12-25', '12-26');
	// The Patron day (if any) is added to public festivities
	if ($patron) {
	  $publicHolidays[] = $patron;
	}
	/*
	 * Array of all Easter Mondays in the given interval
	 */
	$yearStart = date('Y', strtotime($date1));
	$yearEnd   = date('Y', strtotime($date2));
	for ($i = $yearStart; $i <= $yearEnd; $i++) {
	  $easter = date('Y-m-d', easter_date($i));
	  list($y, $m, $g) = explode("-", $easter);
	  $monday = mktime(0,0,0, date($m), date($g)+1, date($y));
	  $easterMondays[] = $monday;
	}
	$start = strtotime($date1);
	$end   = strtotime($date2);
	$workdays = 0;
	for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
	  $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
	  $mmgg = date('m-d', $i);
	  if ($day != $sunday &&
		!in_array($mmgg, $publicHolidays) &&
		!in_array($i, $easterMondays) &&
		!($day == $saturday && $workSat == FALSE)) {
		  $workdays++;
	  }
	}
	return intval($workdays);
  }
?>	