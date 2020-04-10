<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "objects/severImpact.php";
require_once "objects/impact.php";

//creating a mock data
$data = json_decode(json_encode(array(
	"region" => array(
		"name" => "Africa",
		"avgAge" => 20,
		"avgDailyIncomeInUSD" => 5,
		"avgDailyIncomePopulation" => 1
	),
	"periodType" => "days",
	"timeToElapse" => 50,
	"reportedCases" => 800,
	"population" => 26000000,
	"totalHospitalBeds" => 1380614
)));

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