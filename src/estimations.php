<?php 
	require_once "estimator.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Silevestre Dongmo">
	<meta name="Description" content="COVID-19 impact estimation">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>COVID-19 ESTIMATOR</title>
	<link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu+2&display=swap" rel="stylesheet">
	<style type="text/css">
		body{
			font-family: 'Baloo Tammudu 2', 'Eras Medium ITC', 'Century Gothic', 'Comic sans MS', cursive;
			word-spacing: 2px;
			color: black;
		}
		.container{
			width: 40%;
			margin: auto;
			margin-bottom: 200px;
		}
		@media screen and (max-width: 720px){
			.container{
				width: 98%;
			}
			.form-button{
				width: 98%;
			}
		}
		.page-header{
			text-align: center !important;
			padding: 10px 20px;
			margin-bottom: 2px;
			border:solid 1px rgba(10, 200, 20, 0.5);;
			background-color: rgba(10, 200, 20, 0.4);
		}
		.title{
			padding: 0px;
			margin: 0px;
		}
		.header-desc{
			margin: 0px;
			padding: 0px;
			text-decoration: underline;
			letter-spacing: 1px;
		}
		.comment{
			text-align: center;
		}
		.data-head{
			padding: 10px;
			background-color: rgba(10, 200, 20, 0.2);
		}
		.region-data{
			margin-left: 50px;
		}
		.data-set{
			line-height: 3px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h3 class="title">COVID-19 ESTIMATOR</h3>
			<p class="header-desc">A simple estimator for COVID-19</p>
		</div>
		<div class="wrap-content">
			<h4 class="comment">Estimations</h4>
			<?php if (isset($_POST['estimate'])) {
				$data = (object)[];
				$data->region->name = htmlentities($_POST['region']);
				$data->region->avgAge = (float)htmlentities($_POST['avgAge']);
				$data->region->avgDailyIncomeInUSD = (float)htmlentities($_POST['avgDailyIncomeInUSD']);
				$data->region->avgDailyIncomePopulation = (float)htmlentities($_POST['avgDailyIncomePopulation']);
				$data->periodType = htmlentities($_POST['periodType']);
				$data->timeToElapse = (float)htmlentities($_POST['timeToElapse']);
				$data->reportedCases = (int)htmlentities($_POST['reportedCases']);
				$data->population = (int)htmlentities($_POST['population']);
				$data->totalHospitalBeds = (int)htmlentities($_POST['totalHospitalBeds']);

				$result = covid19ImpactEstimator($data); 
			?>
				<div class="input-data data">
					<h3 class="data-head">Input Data</h3>
					<p class="data-set">Region: </p>
					<div class="region-data">
						<p class="data-set">Name: <?= $result['data']['region']['name'] ?></p>
						<p class="data-set">Average Age: <?= $result['data']['region']['avgAge'] ?></p>
						<p class="data-set">Average Daily Income In USD: <?= $result['data']['region']['avgDailyIncomeInUSD'] ?></p>
						<p class="data-set">Average Daily Income Population: <?= $result['data']['region']['avgDailyIncomePopulation'] ?></p>
					</div>
					<p class="data-set">Period Type: <?= $result['data']['periodType'] ?></p>
					<p class="data-set">Time To Elapse: <?= $result['data']['timeToElapse'] ?></p>
					<p class="data-set">Population: <?= $result['data']['population'] ?></p>
					<p class="data-set">Reported Cases: <?= $result['data']['reportedCases'] ?></p>
					<p class="data-set">Total Hospital Beds: <?= $result['data']['totalHospitalBeds'] ?></p>
				</div>
				<div class="impact-data data">
					<h3 class="data-head">Impact</h3>
					<p class="data-set">Currently Infected: <?= $result['impact']['currentlyInfected'] ?></p>
					<p class="data-set">Infections By Requested Time: <?= $result['impact']['infectionsByRequestedTime'] ?></p>
					<p class="data-set">Severe Cases By Requested Time: <?= $result['impact']['severeCasesByRequestedTime'] ?></p>
					<p class="data-set">Hospital Beds By Requested Time: <?= $result['impact']['hospitalBedsByRequestedTime'] ?></p>
					<p class="data-set">Cases For ICU By Requested Time: <?= $result['impact']['casesForICUByRequestedTime'] ?></p>
					<p class="data-set">Cases For Ventilators By Requested Time: <?= $result['impact']['casesForVentilatorsByRequestedTime'] ?></p>
					<p class="data-set">Dollars In Flight: <?= $result['impact']['dollarsInFlight'] ?></p>
				</div>
				<div class="severImpact-data data">
					<h3 class="data-head">Severe Impact</h3>
					<p class="data-set">Currently Infected: <?= $result['severeImpact']['currentlyInfected'] ?></p>
					<p class="data-set">Infections By Requested Time: <?= $result['severeImpact']['infectionsByRequestedTime'] ?></p>
					<p class="data-set">Severe Cases By Requested Time: <?= $result['severeImpact']['severeCasesByRequestedTime'] ?></p>
					<p class="data-set">Hospital Beds By Requested Time: <?= $result['severeImpact']['hospitalBedsByRequestedTime'] ?></p>
					<p class="data-set">Cases For ICU By Requested Time: <?= $result['severeImpact']['casesForICUByRequestedTime'] ?></p>
					<p class="data-set">Cases For Ventilators By Requested Time: <?= $result['severeImpact']['casesForVentilatorsByRequestedTime'] ?></p>
					<p class="data-set">Dollars In Flight: <?= $result['severeImpact']['dollarsInFlight'] ?></p>
				</div>
			<?php } ?>
		</div>
	</div>
</body>
</html>
