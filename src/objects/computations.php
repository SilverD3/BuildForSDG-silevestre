<?php 

/**
* Computations 
*/

class Computations
{
	function normalizeDuration($periodType, $timeToElapse){
		if ($periodType == "days") {
			$days = $timeToElapse;
		}
		if($periodType == "weeks"){
			$days = $timeToElapse * 7;
		}
		if($periodType == "months"){
			$days = $timeToElapse * 30;
		}

		return $days;
	}
	
	function currentlyInfected($reportedCases, $infections_estimation){
		return $reportedCases * $infections_estimation;
	}

	function infectionsByRequestedTime($currentlyInfected, $data){
		$factor = (int)($this->normalizeDuration($data->periodType, $data->timeToElapse)/3);
		$infectionsByRequestedTime = $currentlyInfected * pow(2, $factor);
		return (int)number_format($infectionsByRequestedTime, 0, '.', '');
	}

	function severeCasesByRequestedTime($infectionsByRequestedTime){
		$severeCasesByRequestedTime = $infectionsByRequestedTime * 0.15;
		return (int)number_format($severeCasesByRequestedTime, 0, '.', '');
	}

	function hospitalBedsByRequestedTime($totalHospitalBeds, $severeCasesByRequestedTime){
		$hospitalBedsByRequestedTime = (int)number_format(ceil((float)($totalHospitalBeds * 0.35)) - $severeCasesByRequestedTime, 0, '.', '');
		if($hospitalBedsByRequestedTime>0){
			$hospitalBedsByRequestedTime-=1;
		}

		return $hospitalBedsByRequestedTime;
	}

	function casesForICUByRequestedTime($infectionsByRequestedTime){
		return (int)number_format($infectionsByRequestedTime * 0.05, 0, '.', '');
	}

	function casesForVentilatorsByRequestedTime($infectionsByRequestedTime){
		return (int)number_format((int)($infectionsByRequestedTime*0.02), 0, '.', '');
	}

	function dollarsInFlight($infectionsByRequestedTime, $data){
		$dollarsInFlight = (int)number_format((float)(($infectionsByRequestedTime*$data->region->avgDailyIncomePopulation)*$data->region->avgDailyIncomeInUSD/$this->normalizeDuration($data->periodType, $data->timeToElapse)), 2, '.', '');

		return $dollarsInFlight;
	}
	
}