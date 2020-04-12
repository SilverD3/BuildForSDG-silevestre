<?php 

/**
* Computations 
*/

class Computations
{
	function normalizeDuration($periodType, $timeToElapse){
		switch ($periodType) {
			case 'days':
				return $timeToElapse;
				break;
			case 'weeks':
				return 7 * $timeToElapse; //7 is number of days in a week
				break;
			case 'months':
				return 30 * $timeToElapse; // 30 is number of days in a month
				break;
			default:
				return $timeToElapse;
				break;
		}
	}
	
	function currentlyInfected($reportedCases, $infections_estimation){
		return $reportedCases * $infections_estimation;
	}

	function infectionsByRequestedTime($currentlyInfected, $data){
		$factor = round(($this->normalizeDuration($data->periodType, $data->timeToElapse)/3), 0);
		$infectionsByRequestedTime = $currentlyInfected * pow(2, $factor);
		return round($infectionsByRequestedTime, 0);
	}

	function severeCasesByRequestedTime($infectionsByRequestedTime){
		$severeCasesByRequestedTime = (15 * $infectionsByRequestedTime) / 100;
		return round($severeCasesByRequestedTime, 0);
	}

	function hospitalBedsByRequestedTime($totalHospitalBeds, $severeCasesByRequestedTime){
		$hospitalBedsBRT = (35 * $totalHospitalBeds / 100) - $severeCasesByRequestedTime;
		return round($hospitalBedsBRT, 0);
	}

	function casesForICUByRequestedTime($infectionsByRequestedTime){
		return round((5 * $infectionsByRequestedTime / 100), 0);
	}

	function casesForVentilatorsByRequestedTime($infectionsByRequestedTime){
		return round((2 * $infectionsByRequestedTime / 100), 0);
	}

	function dollarsInFlight($infectionsByRequestedTime, $data){
		$dollarsInFlight = $infectionsByRequestedTime * $data->region->avgDailyIncomeInUSD * $data->region->avgDailyIncomePopulation * $this->normalizeDuration($data->periodType, $data->timeToElapse);

		return round($dollarsInFlight, 0);
	}
	
}
