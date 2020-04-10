<?php 

/**
* Computations 
*/

class Computations
{
	function normalizeDuration($periodType, $timeToElapse){
		switch ($periodType) {
			case 'minutes':
				return $timeToElapse / 1440; //1440 is number of minutes in an hour
				break;
			case 'hours':
				return $timeToElapse / 24; //24 is number of hours in an hour
				break;
			case 'days':
				return $timeToElapse;
				break;
			case 'weeks':
				return $timeToElapse * 7; //7 is number of days in weeks
				break;
			case 'months':
				return $timeToElapse * 30; // 30 is number of days in month
				break;
			
			default:
				return $timeToElapse;
				break;
		}
	}
	
	function currentlyInfected($data, $infections_estimation){
		return $data->reportedCases * $infections_estimation;
	}

	function infectionsByRequestedTime($currentlyInfected, $data){
		//parse timeToElapse into days
		$timeToElapse = $this->normalizeDuration($data->periodType, $data->timeToElapse);
		$factor = pow(2, ($timeToElapse/3));
		$infectionsByRequestedTime = round($currentlyInfected * $factor, 0);
		//set infectionsByRequestedTime equals to poputlation if it is up than region pouplation
		if ($infectionsByRequestedTime > $data->population) {
			$infectionsByRequestedTime = $data->population;
		}
		return $infectionsByRequestedTime;
	}

	function severeCasesByRequestedTime($infectionsByRequestedTime){
		return round((15 * $infectionsByRequestedTime / 100), 2);
	}

	function hospitalBedsByRequestedTime($totalHospitalBeds, $severeCasesByRequestedTime){
		return round(((35 * $totalHospitalBeds / 100) - $severeCasesByRequestedTime), 2);
	}

	function casesForICUByRequestedTime($infectionsByRequestedTime){
		return round((5 * $infectionsByRequestedTime / 100), 2);
	}

	function casesForVentilatorsByRequestedTime($infectionsByRequestedTime){
		return round((2 * $infectionsByRequestedTime / 100), 2);
	}

	function dollarsInFlight($infectionsByRequestedTime, $data){
		return ($infectionsByRequestedTime * $data->region->avgDailyIncomeInUSD * $data->region->avgDailyIncomePopulation * $this->normalizeDuration($data->periodType, $data->timeToElapse));
	}
	
}
