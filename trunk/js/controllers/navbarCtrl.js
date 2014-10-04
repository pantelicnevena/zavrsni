'use strict';

app.controller('navbarCtrl', ['$scope', 'loginService', function($scope,loginService) {
	loginService.islogged().then(function(msg){
		if(!msg.data) $scope.logged = false;
		else $scope.logged = true;
	});
	$scope.a = 'a';
	$scope.logout = function(){
		loginService.logout();
	}
}]);