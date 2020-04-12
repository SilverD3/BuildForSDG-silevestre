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
				return 7 * $timeToElapse; //7 is number of days in weeks
				break;
			case 'months':
				return 30 * $timeToElapse; // 30 is number of days in month
				break;
			
			default:
				return $timeToElapse;
				break;
		}
	}
	
	function currentlyInfected($reportedCases, $infections_estimation){
		return (int)($reportedCases * $infections_estimation);
	}

	function infectionsByRequestedTime($currentlyInfected, $data){
		//parse timeToElapse into days
		$timeToElapse = $this->normalizeDuration($data->periodType, $data->timeToElapse);
		$factor = round(($timeToElapse/3), 0);
		$infectionsByRequestedTime = $currentlyInfected * pow(2, $factor);
		/*//set infectionsByRequestedTime equals to poputlation if it is up than region pouplation
		if ($infectionsByRequestedTime > $data->population) {
			$infectionsByRequestedTime = $data->population;
		}*/
		return round($infectionsByRequestedTime, 0);
	}

	function severeCasesByRequestedTime($infectionsByRequestedTime){
		return round((15 * $infectionsByRequestedTime / 100), 0);
	}

	function hospitalBedsByRequestedTime($totalHospitalBeds, $severeCasesByRequestedTime){
		return round(((35 * $totalHospitalBeds / 100) - $severeCasesByRequestedTime), 0);
	}

	function casesForICUByRequestedTime($infectionsByRequestedTime){
		return round((5 * $infectionsByRequestedTime / 100), 0);
	}

	function casesForVentilatorsByRequestedTime($infectionsByRequestedTime){
		return round((2 * $infectionsByRequestedTime / 100), 0);
	}

	function dollarsInFlight($infectionsByRequestedTime, $data){
		$timeToElapse = $this->normalizeDuration($data->periodType, $data->timeToElapse);
		$dollarsInFlight = $infectionsByRequestedTime * $data->region->avgDailyIncomePopulation * $data->region->avgDailyIncomeInUSD * $timeToElapse;

		return round($dollarsInFlight, 0);
	}
	
}
