'use strict';

app.controller('adminCtrl', ['$scope','loginService', function($scope,loginService){
	$scope.logout=function(){
		loginService.logout();
	}
}])