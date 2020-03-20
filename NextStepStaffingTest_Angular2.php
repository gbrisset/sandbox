<!DOCTYPE html>
<html>

<?php 

include('functions.php');
$ddd = new debug("Next Step Staffing Test Angular JS - Part Deux",3); $ddd->show();

  ?>

<head>
<title>Next Step Staffing Test Angular JS - Part Deux</title>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script>

	app = 	angular.module('exampleModule', []);

		app.controller('scoreController', ['$scope', function($scope) {

			$scope.list = [
				{name: 'Lisa',  score: 95},
				{name: 'John',  score: 80},
				{name: 'Sean',  score: 60},
				{name: 'Sandy', score: 75},
				{name: 'Gary',  score: 45}
			];

		}]);

 //  
</script>		

</head>
<body ng-app="exampleModule">

		<div ng-controller="scoreController">

<ul>
    <li ng-repeat="n in list | orderBy: '-score' " ng-if="n.score >= 75" >{{ n.name + ' has a score of ' + n.score }}</li>
</ul>

		</div>

	</body>

		
</html>		

			
			
	
		