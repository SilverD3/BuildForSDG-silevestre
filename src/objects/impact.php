<?php 
require_once "computations.php";

/**
* Impact class
*/
class Impact extends Computations
{
	function computeImpact($input_data){
		$outputData = (object)[];
		$outputData->currentlyInfected = $this->currentlyInfected($input_data, 10);
		$outputData->infectionsByRequestedTime = $this->infectionsByRequestedTime($outputData->currentlyInfected, $input_data);
		$outputData->severeCasesByRequestedTime = $this->severeCasesByRequestedTime($outputData->infectionsByRequestedTime);
		$outputData->hospitalBedsRequestedByTime = $this->hospitalBedsRequestedByTime($input_data->totalHospitalBeds, $outputData->severeCasesByRequestedTime);
		$outputData->casesForICUByRequestedTime =$this->casesForICUByRequestedTime($outputData->infectionsByRequestedTime);
		$outputData->casesForVentilatorsByRequestedTime = $this->casesForVentilatorsByRequestedTime($outputData->infectionsByRequestedTime);
		$outputData->dollarsInFlight = $this->dollarsInFlight($outputData->infectionsByRequestedTime, $input_data);
		return $outputData;
	}
}

