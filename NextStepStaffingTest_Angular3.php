<!DOCTYPE html>
<html>

<?php 

include('functions.php');
$ddd = new debug("Next Step Staffing Test Angular JS - Angular JS III",3); $ddd->show();

  ?>
	<head>
		<title>Next Step Staffing Test Angular JS - Angular JS III</title>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
		<script>
        angular.module('exampleModule', [])
        .controller('messageController', ['$scope', function($scope) {
        $scope.message = '';
        }])
		</script>
</head>

<body ng-app="exampleModule">

		<div ng-controller="messageController">
			<br/>
			<br/>
			Input: <input ng-model="message" />
			<br/>
			<br/>
			<button>Submit</button>
			<button>Clear</button>
			<br/>
			<br/>
			<div>Message: {{message}}</div>
		</div>

	</body>
</html>		
			
	
		