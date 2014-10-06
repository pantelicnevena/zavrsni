'use strict';
app.factory('loginService',function($http, $location, sessionService){

	return{
		login:function(data,scope){
			var $promise = $http.post('php/zaposleni.php',data); //send data to zaposleni.php
			$promise.then(function(msg){
				var ret = msg.data;
				if(ret){
					//scope.msgtxt='Correct information';
					sessionService.set('uid',ret.uid);
                    sessionService.set('id', ret.id);
                    sessionService.set('role', ret.role);
                    sessionService.set('logged', true);
					$location.path('/');

				}	       
				else  {
					scope.msgtxt='Uneti podaci nisu ispravni. Probajte ponovo.';
					$location.path('/login');
				}				   
			});
		},
		logout:function(){
            $http.post('php/destroy_session.php');
            sessionService.destroy('uid');
            sessionService.destroy('role');
            sessionService.destroy('logged');
            sessionService.destroy('id');
			$location.path('/login');
		},
		islogged:function(){
			var $checkSessionServer = $http.post('php/check_session.php');
			return $checkSessionServer;
		},
        isadmin: function(){
            var $checkAdmin = $http.post('php/check_admin.php');
            return $checkAdmin;
        }
	}

});