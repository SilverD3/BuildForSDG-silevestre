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
		return $outputData;
	}
}

