<!DOCTYPE html>
<html>

<?php 

include('functions.php');
$ddd = new debug("Next Step Staffing Test Angular JS - Four - Quatre - Cuatro",3); $ddd->show();

  ?>

	<head>
		<title>Next Step Staffing Test Angular JS - Four - Quatre - Cuatro</title>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
		<script>
        app = angular.module('exampleModule', []);
        app.controller('messageController', ['$scope', function($scope) {
            $scope.init = {input_txt:"", output_txt:""};
            $scope.message = {input_txt:"", output_txt:""};
            
            $scope.submit = function() {
              $scope.message.output_txt = angular.copy($scope.message.input_txt);
            };//end function submit
            
            $scope.reset = function() {
              $scope.message = angular.copy($scope.init);
            };//end function reset
            
            $scope.reset();//for initial run
            }//end function($scope)...
        ]);//end .controller(...
		</script>
</head>

<body ng-app="exampleModule">

		<div ng-controller="messageController">
			<br/>
			<br/>
			Input: <input ng-model="message.input_txt" />
			<br/>
			<br/>
			<button ng-click="submit()">Submit</button>
			<button ng-click="reset()">Clear</button>
			<br/>
			<br/>
			<div >Message: {{message.output_txt}}</div>
		</div>

	</body>
</html>
		
			
	
		