<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "objects/severImpact.php";
require_once "objects/impact.php";

$data = json_decode(file_get_contents('php://input'));

function covid19ImpactEstimator($data)
{
	$impact = new Impact();
	$severImpact = new SeverImpact();
  	$outputData = [
  		'data' => $data, 
  		'estimate' =>[
	  		'impact' => $impact->computeImpact($data), 
	  		'severeImpact' => $severImpact->computeSeverImpact($data)
	  	]
  	];
  	return $outputData;
}

echo json_encode(covid19ImpactEstimator($data));