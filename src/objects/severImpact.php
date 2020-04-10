<?php 
require_once "computations.php";
/**
* SeverImpact class
*/
class SeverImpact extends Computations
{
	function computeSeverImpact($input_data){
		$outputData = (object)[];
		$outputData->currentlyInfected = $this->currentlyInfected($input_data, 50);
		$outputData->infectionsByRequestedTime = $this->infectionsByRequestedTime($outputData->currentlyInfected, $input_data);
		return $outputData;
	}
}