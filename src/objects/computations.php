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
		$factor = (int)($timeToElapse/3);
		$infectionsByRequestedTime = $currentlyInfected * pow(2, $factor);
		/*//set infectionsByRequestedTime equals to poputlation if it is up than region pouplation
		if ($infectionsByRequestedTime > $data->population) {
			$infectionsByRequestedTime = $data->population;
		}*/
		return (int)$infectionsByRequestedTime;
	}

	function severeCasesByRequestedTime($infectionsByRequestedTime){
		return (int)(15 * $infectionsByRequestedTime / 100);
	}

	function hospitalBedsByRequestedTime($totalHospitalBeds, $severeCasesByRequestedTime){
		return (int)((35 * $totalHospitalBeds / 100) - $severeCasesByRequestedTime);
	}

	function casesForICUByRequestedTime($infectionsByRequestedTime){
		return (int)(5 * $infectionsByRequestedTime / 100);
	}

	function casesForVentilatorsByRequestedTime($infectionsByRequestedTime){
		return (int)(2 * $infectionsByRequestedTime / 100);
	}

	function dollarsInFlight($infectionsByRequestedTime, $data){
		$dollarsInFlight = $infectionsByRequestedTime * $data->region->avgDailyIncomeInUSD * $data->region->avgDailyIncomePopulation * $this->normalizeDuration($data->periodType, $data->timeToElapse);

		return (int)$dollarsInFlight;
	}
	
}
