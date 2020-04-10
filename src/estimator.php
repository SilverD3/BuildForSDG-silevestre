<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "objects/severImpact.php";
require_once "objects/impact.php";

function covid19ImpactEstimator($input_data)
{
	$impact = new Impact();
	$severImpact = new SeverImpact();
  	$outputData = [
  		'data' => json_decode(json_encode($input_data)), 
  		'impact' => $impact->computeImpact(json_decode(json_encode($input_data))), 
  		'severeImpact' => $severImpact->computeSeverImpact(json_decode(json_encode($input_data)))
  	];
  	return json_decode(json_encode($outputData), true);
}
