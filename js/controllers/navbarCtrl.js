'use strict';

app.controller('navbarCtrl', ['$scope', 'loginService', function($scope,loginService) {
    $scope.p = loginService.islogged();
    $scope.p.then(function(msg){

        if(!msg.data) $scope.logged = false;
        else $scope.logged = true;

    });
    $scope.logout=function(){
        loginService.logout();
        $scope.logged = false;
    }
}]);