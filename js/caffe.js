'use strict';

var app = angular.module('caffe', ['ngResource', 'ngRoute']);
var upload = angular.module('app', ['angularFileUpload']);

app.config(function($routeProvider) {
    $routeProvider
        .when('/', {templateUrl: 'view/welcome.html', controller: 'adminCtrl'})
		.when('/admin', {templateUrl: 'view/admin.html', controller: 'adminCtrl'})
		.when('/konobar', {templateUrl: 'view/konobar.html'})
		.when('/izvestaji', {templateUrl: 'view/izvestaji.html'})
        .when('/zaposleni', {templateUrl: 'view/zaposleni.html', controller: 'ZaposleniListCtrl'})
        .when('/artikli', {templateUrl: 'view/artikal.html', controller: 'ArtikalListCtrl'})
        .when('/promeniArtikal', {templateUrl: 'view/promeniArtikal.html', controller: 'PromeniArtikalListCtrl'})
        .when('/porudzbine', {templateUrl: 'view/porudzbina.html', controller: 'PorudzbinaListCtrl'})
        .when('/distributeri', {templateUrl: 'view/distributer.html', controller: 'DistributerListCtrl'})
        .when('/promeniDistributera', {templateUrl: 'view/promeniDistributera.html', controller: 'PromeniDistributeraListCtrl'})
        .when('/kategorije', {templateUrl: 'view/kategorija.html', controller: 'KategorijaListCtrl'})
        .when('/promeniKategoriju', {templateUrl: 'view/promeniKategoriju.html', controller: 'PromeniKategorijuListCtrl'})
        .when('/stolovi', {templateUrl: 'view/sto.html', controller: 'StoListCtrl'})
        .when('/nerazduzeno', {templateUrl: 'view/nerazduzeno.html', controller: 'NerazduzenoListCtrl'})
        .when('/nenapravljena', {templateUrl: 'view/nenapravljena.html', controller: 'NenapravljenaListCtrl'})
        .when('/login', {templateUrl: 'view/login.html', controller: 'loginCtrl'})
		.when('/izmena', {templateUrl: 'view/promeniPodatke.html', controller: 'IzmenaListCtrl'})
		.when('/sopstvene', {templateUrl: 'view/sopstvenePorudzbine.html', controller: 'SopstvenaListCtrl'})
		.when('/dnevni', {templateUrl: 'view/dnevni.html', controller: 'IzvestajListCtrl'})
		.when('/nedeljni', {templateUrl: 'view/nedeljni.html', controller: 'IzvestajListCtrl'})
		.when('/mesecni', {templateUrl: 'view/mesecni.html', controller: 'IzvestajListCtrl'})
		.when('/godisnji', {templateUrl: 'view/godisnji.html', controller: 'IzvestajListCtrl'})
        .when('/godisnjigrafik', {templateUrl: 'view/godisnji-grafik.html'})
        .when('/poruci', {templateUrl: 'view/kreirajPorudzbinu.html', controller: 'PorudzbinaListCtrl'})
        .when('/zaposleniDetalji', {templateUrl: 'view/zaposleniDetalji.html', controller: 'ZaposleniDetaljiListCtrl'})
        .when('/stoDetalji', {templateUrl: 'view/stoDetalji.html', controller: 'StoDetaljiListCtrl'})
        // AngularJS does not allow template-less controllers, so we are specifying a
        // template that we know we won't use. Here is more info on this
        // https://github.com/angular/angular.js/issues/1838
        .when('/logout', {templateUrl: 'login.html', controller: 'LogoutCtrl'})
        .otherwise({redirectTo: '/'});
});

app.run(function($rootScope, $location, loginService){
    var routespermission=['/welcome', '/konobar',
        '/artikli', '/porudzbine',
         '/stolovi', '/nerazduzeno', '/nenapravljena',
        '/izmena', '/sopstvene'
        ];  //route that require login
    var adminroutes = ['/admin', '/kategorije',
        '/izvestaji', '/dnevni', '/nedeljni', '/mesecni', '/godisnji',
        '/zaposleni','/distributeri'];
    $rootScope.$on('$routeChangeStart', function(){

        var admin = loginService.isadmin();
        var loggedIn = loginService.islogged();

        if( routespermission.indexOf($location.path()) !=-1){
            loggedIn.then(function(msg){
                if(!msg.data) $location.path('/login');
            });
        } else
        if (adminroutes.indexOf($location.path()) != -1){
            admin.then(function(msg2){
                if(!msg2.data) $location.path('/');
            });
        } else if($location.path() === '/'){
            admin.then(function(msg2){
                if(msg2.data) $location.path('/admin');
            });
        }

    });
});


/*
 app.config(function($httpProvider) {
 $httpProvider.interceptors.push(function($rootScope, $location, $q) {
 return {
 'request': function(request) {
 // if we're not logged-in to the AngularJS app, redirect to login page
 $rootScope.loggedIn = $rootScope.loggedIn || $rootScope.username;
 if (!$rootScope.loggedIn && $location.path() != '/login') {
 $location.path('/login');
 }
 return request;
 },
 'responseError': function(rejection) {
 // if we're not logged-in to the web service, redirect to login page
 if (rejection.status === 401 && $location.path() != '/login') {
 $rootScope.loggedIn = false;
 $location.path('/login');
 }
 return $q.reject(rejection);
 }
 };
 });
 });
 */
app.factory('EventService', function($resource) {
    return $resource('/api/events/:id');
});

app.factory('KonobarService', function($resource) {
    return $resource('/zavrsni/rest/konobar/:id');
});

app.factory('ArtikalService', function($resource) {
    return $resource('/zavrsni/rest/artikal/:id');
});

app.factory('PorudzbinaService', function($resource) {
    return $resource('/zavrsni/rest/porudzbina/:id');
});

app.factory('StavkaService', function($resource) {
    return $resource('/zavrsni/rest/stavka/:id');
});

app.factory('RazduzenjeService', function($resource) {
    return $resource('/zavrsni/rest/razduzenje/:id');
});

app.factory('DistributerService', function($resource) {
    return $resource('/zavrsni/rest/distributer/:id');
});

app.factory('KategorijaService', function($resource) {
    return $resource('/zavrsni/rest/kategorija/:id');
});

app.factory('StoService', function($resource) {
    return $resource('/zavrsni/rest/sto/:id');
});

app.factory('StavkaService', function($resource) {
    return $resource('/zavrsni/rest/stavka/:id');   //zavrsni/rest/stavka/@porudzbinaID
});

app.factory('NerazduzenoService', function($resource) {
    return $resource('/zavrsni/rest/porudzbina/razduzeno/0');
});

app.factory('NenapravljenaService', function($resource) {
    return $resource('/zavrsni/rest/porudzbina/napravljena/0');
});

app.factory('SopstvenaService', function($resource) {
    return $resource('/zavrsni/rest/porudzbina/:id');
});

app.factory('DnevniService', function($resource) {
    return $resource('/zavrsni/rest/porudzbina/datum/:datum');
});

app.factory('PosledenjeNedeljeService', function($resource) {
    return $resource('/zavrsni/rest/porudzbina/poslednje/nedelje');
});

app.factory('PosledenjegMesecaService', function($resource) {
    return $resource('/zavrsni/rest/porudzbina/poslednje/mesec');
});

app.factory('PosledenjeGodineService', function($resource) {
    return $resource('/zavrsni/rest/porudzbina/poslednje/godine');
});

app.factory('SessionService', function($resource) {
    return $resource('/zavrsni/rest/konobar/');
});

upload.controller('AppController', ['$scope', 'FileUploader', function($scope, FileUploader) {
        var uploader = $scope.uploader = new FileUploader({
            url: 'upload.php'
        });

        // FILTERS

        uploader.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 10;
            }
        });

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {
            console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        uploader.onCompleteAll = function() {
            console.info('onCompleteAll');
        };

        console.info('uploader', uploader);
    }]);


app.controller('LoginCtrl', function($scope, $rootScope, $location, SessionService) {
    $scope.konobar = {
		korisnickoIme: '', 
		korisnickaSifra: ''
	};

    $scope.login = function() {
        $scope.konobar = SessionService.save($scope.konobar, function(success) {
            $rootScope.loggedIn = true;
            $location.path('/');
        }, function(error) {
            $scope.loginError = true;
        });
    };
});

app.controller('LogoutCtrl', function($rootScope, $location, SessionService) {
    (new SessionService()).$delete(function(success) {
        $rootScope.loggedIn = false;
        $location.path('/login');
    });
});


app.controller('EventListCtrl', function($scope, $location, EventService) {

    EventService.query(function(events){
        $scope.events = events;
    });

    $scope.editEvent = function(event) {
        $scope.opts = ['on', 'off'];

        if (event === 'new') {
            $scope.newEvent = true;
            $scope.event = {name: '', shortname: '', phonenumber: '', state: '', voteoptions: [{id:1, name: ''}]};
        }
        else {
            $scope.newEvent = false;
            $scope.event = event;
        }
    };

    /*$scope.save = function() {
     if (!$scope.event._id) {
     var newEvent = new EventService($scope.event);
     newEvent.$save(function(){
     $scope.events.push(newEvent);
     });
     }
     else {
     $scope.events.forEach(function(e) {
     if (e._id === $scope.event._id) {
     e.$save();
     }
     });
     }
     };*/

    $scope.delete = function() {
        $scope.events.forEach(function(e, index) {
            if (e._id == $scope.event._id) {
                $scope.event.$delete({id: $scope.event._id, rev: $scope.event._rev}, function() {
                    $scope.events.splice(index, 1);
                });
            }
        });
    };

    $scope.addVoteOption = function() {
        $scope.event.voteoptions.push({id: $scope.event.voteoptions.length+1, name: null});
    };

    $scope.removeVoteOption = function(vo) {
        $scope.event.voteoptions.splice(vo.id-1, 1);
        // need to make sure id values run from 1..x (web service constraint)
        $scope.event.voteoptions.forEach(function(vo, index) {
            vo.id = index+1;
        });
    };
});


app.controller('ZaposleniListCtrl',function($scope, $location, KonobarService) {

    KonobarService.query(function(konobari){
        $scope.konobari = konobari;
    });


    $scope.izmeniKonobara = function (konobar) {
        console.log(konobar);
        if(konobar === 'novi'){
            $scope.noviKonobar = true;
            $scope.konobar = {
                ime: "",
                prezime: "",
                godinaRodjenja: "",
                mestoRodjenja: "",
                korisnickoIme: "",
                korisnickaSifra: "",
                role: "",
                slika: ""
            };
        }
        else {
            $scope.noviKonobar = false;
            $scope.konobar = konobar;
        }
    }

    $scope.save = function(konobar) {
         if (!$scope.konobar.konobarID) {
             var noviKonobar = new KonobarService($scope.konobar);
             if (noviKonobar.slika === "") noviKonobar.slika = "default.jpg";
             if (noviKonobar.ime === ""
                 || noviKonobar.prezime===""
                 || noviKonobar.godinaRodjenja===""
                 || noviKonobar.mestoRodjenja===""
                 || noviKonobar.korisnickoIme===""
                 || noviKonobar.korisnickaSifra===""
                 || noviKonobar.role===""){
					//$msg = "Niste popunili sva polja.";
                    window.alert("Niste popunili sva polja.");
             }else{
                 noviKonobar.$save(function(){
                     $scope.konobari.push(noviKonobar)
                 });
             }

         } else {
             $scope.konobari.forEach(function(e) {
                 if (e.konobarID === $scope.konobar.konobarID) {
                     e.$save({id: e.konobarID});
                 }
             });
         }
     };

     $scope.delete = function(konobar) {
		$scope.konobar = konobar;
		$scope.konobari.forEach(function(e, index) {
			if (e.konobarID === $scope.konobar.konobarID) {
				$scope.konobar.$delete({id: $scope.konobar.konobarID}, function() {
                    $scope.konobari.splice(index, 1);
                 });
             }
         });
     };

    $scope.orderByField = 'ime';
    $scope.reverseSort = false;
});



app.controller('ArtikalListCtrl',function($scope, $location, ArtikalService, KategorijaService, DistributerService) {

    ArtikalService.query(function(artikli){
        $scope.artikli = artikli;
    });

    KategorijaService.query(function(kategorije){
        $scope.kategorije = kategorije;
    });

    DistributerService.query(function(distributeri){
        $scope.distributeri = distributeri;
    });

    $scope.izmeniArtikal = function (artikal) {
        if(artikal === 'novi'){
            $scope.noviArtikal = true;
            $scope.artikal = {
                nazivArtikla: "",
                ambalaza: "",
                rokTrajanja: "",
                stanjeNaZalihama: "",
                cena: "",
                distributerID: "",
                kategorijaID: ""
            };
        }
        else {
            $scope.noviArtikal = false;
            $scope.artikal = artikal;
        }
    }


    $scope.save = function() {
        if (!$scope.artikal.artikalID) {
            var noviArtikal = new ArtikalService($scope.artikal);
            if (noviArtikal.nazivArtikla === ""
                || noviArtikal.ambalaza===""
                || noviArtikal.rokTrajanja===""
                || noviArtikal.stanjeNaZalihama===""
                || noviArtikal.cena===""
                || noviArtikal.distributerID===""
                || noviArtikal.kategorijaID===""){
                window.alert("Niste popunili sva polja.");
            }else{
                noviArtikal.$save(function(){
                    $scope.artikli.push(noviArtikal);
                });
            }
        }
        else {
            $scope.artikli.forEach(function(e) {
                if (e.artikalID === $scope.artikal.artikalID) {
                    e.$save({id: e.artikalID});
                }
            });
        }
    };

    $scope.sacuvaj = function(artikal){
        console.log(artikal);
        artikal.$save({id: artikal.artikalID});
        alert("Podaci su uspesno sacuvani.");
    }

    $scope.delete = function(artikal) {
        $scope.artikli.forEach(function(e, index) {
            if (e.artikalID === $scope.artikal.artikalID) {
                $scope.artikal.$delete({id: $scope.artikal.artikalID}, function() {
                    $scope.artikli.splice(index, 1);
                });
            }
        });
    };

    $scope.orderByField = 'nazivArtikla';
    $scope.reverseSort = false;
});

app.controller('PorudzbinaListCtrl',function($http, $scope, $location, PorudzbinaService, KonobarService, StoService, StavkaService, ArtikalService) {


    PorudzbinaService.query(function(porudzbine){
        $scope.porudzbine = porudzbine;
    });

    $scope.currentPage = 0;
    $scope.pageSize = 10;
    $scope.porudzbine = [];
    $scope.maxNumPages;
    for (var i=0; i<50; i++) {
        $scope.porudzbine.push("Item "+i);
    }

	StavkaService.query(function(stavke){
		$scope.stavke = stavke;
	});
	
	ArtikalService.query(function(artikli){
		$scope.artikli = artikli;
	});

    KonobarService.query(function(konobari){
        $scope.konobari = konobari;
    });

    StoService.query(function(stolovi){
        $scope.stolovi = stolovi;
    });

    $scope.izmeniPorudzbinu = function (porudzbina) {

        var n = new Date();
        var yyyy = n.getFullYear();
        if (n.getMonth()+1 < 10){
            var m = n.getMonth()+1;
            var mm = "0"+m;
        }else { var mm = n.getMonth()+1}
        var dd = n.getDate();
        var datum = yyyy+'-'+mm+'-'+dd;

        if(porudzbina === 'novi'){
            $scope.novaPorudzbina = true;
            $scope.porudzbina = {
                datumPorudzbine: datum,
                razduzeno: "",
                napravljena: "",
                konobarID: "",
                stoID: "",
                razduzenjeID: ""
            };
        }
        else {
			$scope.novaPorudzbina = false;
            $scope.porudzbina = porudzbina;
        }
    }

    $scope.poruci = function() {
        var n = new Date();
        var yyyy = n.getFullYear();
        if (n.getMonth()+1 < 10){
            var m = n.getMonth()+1;
            var mm = "0"+m;
        }else { var mm = n.getMonth()+1}
        var dd = n.getDate();
        var datum = yyyy+'-'+mm+'-'+dd;
        var $konobarID = sessionStorage.id;
        var novaPorudzbina = new PorudzbinaService($scope.porudzbina);
        novaPorudzbina.datumPorudzbine = datum;
        novaPorudzbina.konobarID = $konobarID;
        novaPorudzbina.razduzeno = "0";
        novaPorudzbina.napravljena = "0";

        console.log(novaPorudzbina);
        var $promise = $http.post('php/porudzbinaID.php',novaPorudzbina);
        $promise.then(function(msg){
            console.log(msg.data);
            sessionStorage.index = msg.data;
        });
        /*if(novaPorudzbina.stoID){
            novaPorudzbina.$save(function(){
               $scope.porudzbine.push(novaPorudzbina);
            });
            $scope.porudzbina.msg = "Porudzbina je uspesno sacuvana.";
        }*/
    }

    var stavke = [];
    $scope.dodaj = function(stavka){
        $scope.msg = "";
        $scope.noveStavke = stavke;
        if (stavka == 'sacuvaj'){
            for (var i = 0; i<stavke.length; i++){
                stavke[i].$save(function(){
                    $scope.stavke.push(stavke[i]);
                });
            }
            sessionStorage.removeItem("index");
        }else{
            var novaStavka = new StavkaService($scope.stavka);
            if (!novaStavka.artikalID || !novaStavka.kolicina) $scope.msg="Niste prosledili potrebne podatke.";
            else{
                for (var i = 0; i<$scope.artikli.length; i++){
                    var artikal = $scope.artikli[i];
                    if (artikal.artikalID == novaStavka.artikalID) {
                        novaStavka.nazivArtikla = artikal.nazivArtikla;
                        novaStavka.cena = artikal.cena;
                    }
                }
                novaStavka.porudzbinaID = sessionStorage.index;
                stavke.push(novaStavka);
                $scope.ukupnaVrednost = Math.abs(stavke[0].cena)*Math.abs(stavke[0].kolicina);
                for (var i = 1; i<stavke.length; i++){
                    console.log(stavke[i]);
                    $scope.ukupnaVrednost += Math.abs(stavke[i].cena)*Math.abs(stavke[i].kolicina);
                }
            }

        }
        /*var novaStavka = new StavkaService($scope.stavka);
        novaStavka.porudzbinaID = sessionStorage.index;
        console.log(novaStavka);
        novaStavka.$save(function(){
            $scope.stavke.push(novaStavka);
            alert("sacuvana stavka");
        });*/
    }

    $scope.razduzi = function() {
        if ($scope.porudzbina) console.log($scope.porudzbina);
        if (!$scope.porudzbina.porudzbinaID) {
            var novaPorudzbina = new PorudzbinaService($scope.porudzbina);
            novaPorudzbina.$save(function(){
                $scope.porudzbine.push(novaPorudzbina);
            });
        } else {
            $scope.porudzbine.forEach(function(e) {
                if (e.porudzbinaID === $scope.porudzbina.porudzbinaID) {
                    e.razduzeno = "1";
                    console.log(e);
                    e.$save({id: e.porudzbinaID});
                }
            });
        }
    };

    $scope.napravi = function() {
        if (!$scope.porudzbina.porudzbinaID) {
            var novaPorudzbina = new PorudzbinaService($scope.porudzbina);
            novaPorudzbina.$save(function(){
                $scope.porudzbine.push(novaPorudzbina);
            });
        } else {
            $scope.porudzbine.forEach(function(e) {
                if (e.porudzbinaID === $scope.porudzbina.porudzbinaID) {
                    e.napravljena = "1";
                    console.log(e);
                    e.$save({id: e.porudzbinaID});
                }
            });
        }
    };

     $scope.save = function() {
         if ($scope.porudzbina) console.log($scope.porudzbina);
         if (!$scope.porudzbina.porudzbinaID) {
            var novaPorudzbina = new PorudzbinaService($scope.porudzbina);
            novaPorudzbina.$save(function(){
                $scope.porudzbine.push(novaPorudzbina);
            });
        } else {
            $scope.porudzbine.forEach(function(e) {
                if (e.porudzbinaID === $scope.porudzbina.porudzbinaID) {
                    e.$save({id: e.porudzbinaID});
                }
            });
        }
    };

    $scope.orderByField = 'datumPorudzbine';
    $scope.reverseSort = false;

    $scope.delete = function(porudzbina) {
        $scope.porudzbine.forEach(function(e, index) {
            if (e.porudzbinaID == $scope.porudzbina.porudzbinaID) {
                $scope.porudzbina.$delete({id: $scope.porudzbina.porudzbinaID}, function() {
                    $scope.porudzbine.splice(index, 1);
                });
            }
        });
    };

});

app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});

app.controller('DistributerListCtrl',function($scope, $location, DistributerService) {

    DistributerService.query(function(distributeri){
        $scope.distributeri = distributeri;

    });

    $scope.izmeniDistributera = function (distributer) {

        if(distributer === 'novi'){
            $scope.noviDistributer = true;
            $scope.distributer = {
                nazivDistributera: ""
            };
        }
        else {
            $scope.noviDistributer = false;
            $scope.distributer = distributer;
        }
    }

    $scope.save = function() {
        if (!$scope.distributer.distributerID) {
            var noviDistributer = new DistributerService($scope.distributer);
            if (noviDistributer.nazivDistributera === ""){
                window.alert("Niste popunili polje za naziv distributera.");
            }else{
                noviDistributer.$save(function(){
                    $scope.distributeri.push(noviDistributer);
                });
            }
        } else {
            $scope.distributeri.forEach(function(e) {
                if (e.distributerID === $scope.distributer.distributerID) {
                    e.$save({id: e.distributerID});
                }
            });
        }
    };

    $scope.sacuvaj = function(distributer){
        console.log(distributer);
        distributer.$save({id: distributer.distributerID});
        alert("Podaci su uspesno sacuvani.");
    }

    $scope.orderByField = 'nazivDistributera';
    $scope.reverseSort = false;


    $scope.delete = function(distributer) {
        $scope.distributeri.forEach(function(e, index) {
            if (e.distributerID == $scope.distributer.distributerID) {
                $scope.distributer.$delete({id: $scope.distributer.distributerID}, function() {
                    $scope.distributeri.splice(index, 1);
                });
            }
        });
    };

});

app.controller('KategorijaListCtrl',function($scope, $location, KategorijaService) {

    KategorijaService.query(function(kategorije){
        $scope.kategorije = kategorije;
    });

    /*KategorijaService.query({id: 1}, function(kategorije){
     $scope.kategorije = kategorije;
     });*/

    $scope.izmeniKategoriju = function (kategorija) {

        if(kategorija === 'novi'){
            $scope.novaKategorija = true;
            $scope.kategorija = {
                nazivKategorije: ""
            };
        }
        else {
            $scope.novaKategorija = false;
            $scope.kategorija = kategorija;
        }
    }

    $scope.save = function() {
        if (!$scope.kategorija.kategorijaID) {
            var novaKategorija = new KategorijaService($scope.kategorija);
            if (novaKategorija.nazivKategorije === ""){
                window.alert("Niste popunili polje za naziv kategorije.");
            }else{
                novaKategorija.$save(function(){
                    $scope.kategorije.push(novaKategorija);
                });
            }
        } else {
            $scope.kategorije.forEach(function(e) {
                if (e.kategorijaID === $scope.kategorija.kategorijaID) {
                    e.$save({id: e.kategorijaID});
                }
            });
        }
    };

    $scope.delete = function(kategorija) {
        $scope.kategorije.forEach(function(e, index) {
            if (e.kategorijaID == $scope.kategorija.kategorijaID) {
                $scope.kategorija.$delete({id: $scope.kategorija.kategorijaID}, function() {
                    $scope.kategorije.splice(index, 1);
                });
            }
        });
    };

    $scope.orderByField = 'nazivKategorije';
    $scope.reverseSort = false;

});

app.controller('StavkaListCtrl',function($scope, $location, StavkaService, ArtikalService, PorudzbinaService) {

    StavkaService.query(function(stavke){
        $scope.stavke = stavke;
    });

    ArtikalService.query(function(artikli){
        $scope.artikli = artikli;
    });

    PorudzbinaService.query(function(porudzbine){
        $scope.porudzbine = porudzbine;
    });

    $scope.izmeniStavku = function (stavka) {

        if(stavka === 'novi'){
            $scope.novaStavka = true;
            $scope.stavka = {
                koilicina: "",
                porudzbinaID: "",
                artikalID: ""
            };
        }
        else {
            $scope.novaStavka = false;
            $scope.stavka = stavka;
        }
    }

    $scope.dodaj = function(){
        var stavke = [];
        if ($scope.sacuvaj){}
            var novaStavka = new StavkaService($scope.stavka);
            novaStavka.porudzbinaID = "5540";
            console.log(novaStavka);
            novaStavka.$save(function(){
                $scope.stavke.push(novaStavka);
                alert("sacuvana stavka");

        });
    }

    $scope.save = function() {
        if (!$scope.stavka.redniBrojStavke) {
            var novaStavka = new StavkaService($scope.stavka);
            if (novaStavka.kolicina === "" || novaStavka.porudzbinaID === "" || novaStavka.artikalID === ""){
                window.alert("Niste popunili sva polja.");
            }else{
                novaStavka.$save(function(){
                    $scope.stavke.push(novaStavka);
                });
            }
        } else {
            $scope.stavke.forEach(function(e) {
                if (e.redniBrojStavke === $scope.stavka.redniBrojStavke) {
                    e.$save({id: e.rednibrojStavke});
                }
            });
        }
    };

    $scope.delete = function(stavka) {
        $scope.stavke.forEach(function(e, index) {
            if (e.redniBrojStavke == $scope.stavka.redniBrojStavke) {
                $scope.stavka.$delete({id: $scope.stavka.redniBrojStavke}, function() {
                    $scope.stavke.splice(index, 1);
                });
            }
        });
    };

    $scope.orderByField = 'porudzbinaID';
    $scope.reverseSort = false;

});

app.controller('StoListCtrl',function($scope, $location, StoService) {

    $scope.currentPage = 0;
    $scope.pageSize = 10;
    $scope.data = [];
    for (var i=0; i<50; i++) {
        $scope.data.push("Item "+i);
    }

    StoService.query(function(stolovi){
        $scope.stolovi = stolovi;

    });

    $scope.izmeniSto = function (sto) {

        if(sto === 'novi'){
            $scope.noviSto = true;
            $scope.sto = {
                brojStola: ""
            };
        }
        else {
            $scope.noviSto = false;
            $scope.sto = sto;
        }
    }

    $scope.save = function() {
        if (!$scope.sto.stoID) {
            var noviSto = new StoService($scope.sto);
            if (noviSto.brojStola === ""){
                window.alert("Niste popunili polje za redni broj stola.");
            }else{
                noviSto.$save(function(){
                    $scope.stolovi.push(noviSto);
                });
            }
        } else {
            $scope.stolovi.forEach(function(e) {
                if (e.stoID === $scope.sto.stoID) {
                    e.$save({id: e.stoID});
                }
            });
        }
    };

    $scope.delete = function(sto) {
        $scope.stolovi.forEach(function(e, index) {
            if (e.stoID == $scope.sto.stoID) {
                $scope.sto.$delete({id: $scope.sto.stoID}, function() {
                    $scope.stolovi.splice(index, 1);
                });
            }
        });
    };

	$scope.orderByField = 'brojStola';
    $scope.reverseSort = false;

});

app.controller('NerazduzenoListCtrl',function($scope, $location, NerazduzenoService, KonobarService, StoService) {

    NerazduzenoService.query(function(porudzbine){
        $scope.porudzbine = porudzbine;
    });

    KonobarService.query(function(konobari){
        $scope.konobari = konobari;
    });

    StoService.query(function(stolovi){
        $scope.stolovi = stolovi;
    });

    $scope.izmeniPorudzbinu = function (porudzbina) {

        var n = new Date();
        var yyyy = n.getFullYear();
        if (n.getMonth()+1 < 10){
            var m = n.getMonth()+1;
            var mm = "0"+m;
        }else { var mm = n.getMonth()+1}
        var dd = n.getDate();
        var datum = yyyy+'-'+mm+'-'+dd;

        if(porudzbina === 'novi'){
            $scope.novaPorudzbina = true;
            $scope.porudzbina = {
                datumPorudzbine: datum,
                razduzeno: "",
                konobarID: "",
                stoID: "",
                razduzenjeID: ""
            };
        }
        else {
            $scope.novaPorudzbina = false;
            $scope.porudzbina = porudzbina;
        }
    }


    $scope.save = function() {
        if (!$scope.porudzbina.porudzbinaID) {
            var novaPorudzbina = new NerazduzenoService($scope.porudzbina);
            novaPorudzbina.$save(function(){
                $scope.porudzbine.push(novaPorudzbina);
            });
        } else {
            $scope.porudzbine.forEach(function(e) {
                if (e.porudzbinaID === $scope.porudzbina.porudzbinaID) {
                    e.$save();
                }
            });
        }
    };

    $scope.orderByField = 'datumPorudzbine';
	$scope.reverseSort = false;

    $scope.delete = function(porudzbina) {
        $scope.porudzbine.forEach(function(e, index) {
            if (e.porudzbinaID == $scope.porudzbina.porudzbinaID) {
                $scope.porudzbina.$delete({id: $scope.porudzbina.porudzbinaID}, function() {
                    $scope.porudzbine.splice(index, 1);
                });
            }
        });
    };

});

app.controller('SopstvenaListCtrl',function($scope, $location, SopstvenaService, KonobarService, StoService, StavkaService, RazduzenjeService) {

    var $konobarID = sessionStorage.id;

    SopstvenaService.query({id: $konobarID},function(porudzbine){
        $scope.porudzbine = porudzbine;
    });
		
	StavkaService.query(function(stavke){
		$scope.stavke = stavke;
	});
	
	RazduzenjeService.query(function(razduzenja){
		$scope.razduzenja = razduzenja;
	});
	
	/*PorudzbinaService.query({id: 5533}, function(porudzbine){
		$scope.porudzbine = porudzbine;
	});*/
	
	//http://stackoverflow.com/questions/14523679/can-you-pass-parameters-to-an-angularjs-controller-on-creation
	//http://fdietz.github.io/recipes-with-angular-js/consuming-external-services/consuming-restful-apis.html

    KonobarService.query(function(konobari){
        $scope.konobari = konobari;
    });

    StoService.query(function(stolovi){
        $scope.stolovi = stolovi;
    });

    $scope.izmeniPorudzbinu = function (porudzbina) {

        var n = new Date();
        var yyyy = n.getFullYear();
        if (n.getMonth()+1 < 10){
            var m = n.getMonth()+1;
            var mm = "0"+m;
        }else { var mm = n.getMonth()+1}
        var dd = n.getDate();
        var datum = yyyy+'-'+mm+'-'+dd;

        if(porudzbina === 'novi'){
            $scope.novaPorudzbina = true;
            $scope.porudzbina = {
                datumPorudzbine: datum,
                razduzeno: "",
                konobarID: "",
                stoID: "",
                razduzenjeID: ""
            };
        }
        else {
			$scope.novaPorudzbina = false;
            $scope.porudzbina = porudzbina;
        }
    }


     $scope.save = function() {
        if (!$scope.porudzbina.porudzbinaID) {
            var novaPorudzbina = new PorudzbinaService($scope.porudzbina);
            novaPorudzbina.$save(function(){
                $scope.porudzbine.push(novaPorudzbina);
            });
        } else {
            $scope.porudzbine.forEach(function(e) {
                if (e.porudzbinaID === $scope.porudzbina.porudzbinaID) {
                    e.$save({id: e.porudzbinaID});
                }
            });
        }
    };

    $scope.orderByField = 'datumPorudzbine';
    $scope.reverseSort = false;

    $scope.delete = function(porudzbina) {
        $scope.porudzbine.forEach(function(e, index) {
            if (e.porudzbinaID == $scope.porudzbina.porudzbinaID) {
                $scope.porudzbina.$delete({id: $scope.porudzbina.porudzbinaID}, function() {
                    $scope.porudzbine.splice(index, 1);
                });
            }
        });
    };

});


app.controller('NenapravljenaListCtrl',function($scope, $location, NenapravljenaService, KonobarService, StoService) {

	NenapravljenaService.query(function(porudzbine){
		$scope.porudzbine = porudzbine;
        console.log(porudzbine);
	});

	KonobarService.query(function(konobari){
		$scope.konobari = konobari;
	});

	StoService.query(function(stolovi){
		$scope.stolovi = stolovi;
	});


    $scope.izmeniPorudzbinu = function (porudzbina) {

        var n = new Date();
        var yyyy = n.getFullYear();
        if (n.getMonth()+1 < 10){
            var m = n.getMonth()+1;
            var mm = "0"+m;
        }else { var mm = n.getMonth()+1}
        var dd = n.getDate();
        var datum = yyyy+'-'+mm+'-'+dd;

        if(porudzbina === 'novi'){
            $scope.novaPorudzbina = true;
            $scope.porudzbina = {
                datumPorudzbine: datum,
                razduzeno: "",
                konobarID: "",
                stoID: "",
                razduzenjeID: ""
            };
        }
        else {
            $scope.novaPorudzbina = false;
            $scope.porudzbina = porudzbina;
        }
    }


    $scope.save = function() {
        if (!$scope.porudzbina._id) {
            var novaPorudzbina = new PorudzbinaService($scope.porudzbina);
            novaPorudzbina.$save(function(){
                $scope.porudzbine.push(novaPorudzbina);
            });
        } else {
            $scope.porudzbine.forEach(function(e) {
                if (e._id === $scope.porudzbina._id) {
                    e.$save();
                }
            });
        }
    };

    $scope.orderByField = 'datumPorudzbine';
	$scope.reverseSort = false;


    $scope.delete = function(porudzbina) {
        $scope.porudzbine.forEach(function(e, index) {
            if (e.porudzbinaID == $scope.porudzbina.porudzbinaID) {
                $scope.porudzbina.$delete({id: $scope.porudzbina.porudzbinaID}, function() {
                    $scope.porudzbine.splice(index, 1);
                });
            }
        });
    };

});

app.controller('IzmenaListCtrl',function($scope, $location, KonobarService) {

	var $konobarID = sessionStorage.id;
    KonobarService.query({id: $konobarID}, function(konobari){
        $scope.konobari = konobari;
    });
	
	/*var $konobarID;
	
	if($scope.konobarID){
		$konobarID = konobarID;
	}else{
		$konobarID = sessionStorage.id;
		KonobarService.query({id: $konobarID}, function(konobari){
			$scope.konobari = konobari;
		});
	}*/
    	
	$scope.save = function(konobar){
		konobar.$save({id: konobar.konobarID});
		alert("Podaci su uspesno sacuvani.");
	}
	
	$scope.izmeniKonobara = function(konobar){
		if (konobar.konobarID) {
			$scope.konobar = konobar;
			var $konobarID = konobar.konobarID;
			KonobarService.query({id: $konobarID}, function(konobari){
			$scope.konobari = konobari;
			});
		}
		return $scope.konobari;
	}
    
     $scope.delete = function(konobar) {
         $scope.konobari.forEach(function(e, index) {
             if (e.konobarID == $scope.konobar.konobarID) {
                 $scope.konobar.$delete({id: $scope.konobar.konobarID}, function() {
                     $scope.konobari.splice(index, 1);
                 });
             }
         });
     };

    $scope.orderByField = 'ime';
    $scope.reverseSort = false;
});


app.controller('IzvestajListCtrl',function($scope, $location, DnevniService, PosledenjeNedeljeService, PosledenjegMesecaService, PosledenjeGodineService, KonobarService, StoService, StavkaService, RazduzenjeService) {

	var n = new Date();
    var yyyy = n.getFullYear();
    if (n.getMonth()+1 < 10){
        var m = n.getMonth()+1;
        var mm = "0"+m;
    }else { 
		var mm = n.getMonth()+1
	}
    var dd = n.getDate();
    var datum = yyyy+'-'+mm+'-'+dd;

    DnevniService.query({datum: datum}, function(dnevne){
        $scope.dnevne = dnevne;
    });
	
	PosledenjeNedeljeService.query(function(nedeljni){
        $scope.nedeljni = nedeljni;
    });
	
	PosledenjegMesecaService.query(function(mesecni){
        $scope.mesecni = mesecni;
    });
	
	PosledenjeGodineService.query(function(godine){
        $scope.godine = godine;
    });
		
	StavkaService.query(function(stavke){
		$scope.stavke = stavke;
	});
	
	RazduzenjeService.query(function(razduzenja){
		$scope.razduzenja = razduzenja;
	});
	
	
    KonobarService.query(function(konobari){
        $scope.konobari = konobari;
    });

    StoService.query(function(stolovi){
        $scope.stolovi = stolovi;
    });


    $scope.orderByField = 'datumPorudzbine';
    $scope.reverseSort = false;


});


app.controller('ZaposleniDetaljiListCtrl',function($scope, $location, KonobarService) {

    $scope.izmena = function(konobar){
        $scope.konobar = konobar;
        var konobarID = konobar.konobarID;
        sessionStorage.index = konobarID;
    }

    console.log($scope.konobar);
    var $konobarID = sessionStorage.index;
    KonobarService.query({id: $konobarID}, function(konobari){
        $scope.konobari = konobari;
    });

    $scope.izmeniKonobara = function (konobar) {
        if(konobar === 'novi'){
            $scope.noviKonobar = true;
            $scope.konobar = {
                ime: "",
                prezime: "",
                godinaRodjenja: "",
                mestoRodjenja: "",
                korisnickoIme: "",
                korisnickaSifra: "",
                role: "",
                slika: ""
            };
        }
        else {
            $scope.noviKonobar = false;
            $scope.konobar = konobar;
        }
    }

    $scope.save = function(konobar){
        konobar.$save({id: konobar.konobarID});
        window.location.href = "#/zaposleni";
        alert("Podaci su uspesno sacuvani.");
        sessionStorage.removeItem("index");
    }

    /*$scope.save = function(konobar) {
        if (!$scope.konobar.konobarID) {
            var noviKonobar = new KonobarService($scope.konobar);
            if (noviKonobar.slika === "") noviKonobar.slika = "default.jpg";
            if (noviKonobar.ime === ""
                || noviKonobar.prezime===""
                || noviKonobar.godinaRodjenja===""
                || noviKonobar.mestoRodjenja===""
                || noviKonobar.korisnickoIme===""
                || noviKonobar.korisnickaSifra===""
                || noviKonobar.role===""){
                //$msg = "Niste popunili sva polja.";
                window.alert("Niste popunili sva polja.");
            }else{
                noviKonobar.$save(function(){
                    $scope.konobari.push(noviKonobar)
                });
            }

        } else {
            $scope.konobari.forEach(function(e) {
                if (e.konobarID === $scope.konobar.konobarID) {
                    e.$save({id: e.konobarID});
                }
            });
        }
    };*/

    $scope.delete = function(konobar) {
        $scope.konobar = konobar;
        $scope.konobari.forEach(function(e, index) {
            if (e.konobarID === $scope.konobar.konobarID) {
                $scope.konobar.$delete({id: $scope.konobar.konobarID}, function() {
                    $scope.konobari.splice(index, 1);
                });
            }
        });
    };

    $scope.orderByField = 'ime';
    $scope.reverseSort = false;
});

app.controller('StoDetaljiListCtrl',function($scope, $location, StoService) {

    $scope.izmena = function(sto){
        if(sto === 'novi'){
            $scope.noviSto = true;
            $scope.sto = {
                brojStola: ""
            };
        }
        else {
            $scope.noviSto = false;
            $scope.sto = sto;
            var stoID = sto.stoID;
            sessionStorage.index = stoID;
            console.log(stoID);
        }
    }


        StoService.query({id: sessionStorage.index}, function(stolovi){
        $scope.stolovi = stolovi;
        });


    $scope.izmeniSto = function (sto) {
        if(sto === 'novi'){
            $scope.noviSto = true;
            $scope.sto = {
                brojStola: ""
            };
        }
        else {
            $scope.noviSto = false;
            $scope.sto = sto;
        }
    }

    $scope.save = function(sto){
        sto.$save({id: sto.stoID});
        window.location.href = "#/stolovi";
        alert("Podaci su uspesno sacuvani.");
        sessionStorage.removeItem("index");
    }

    /*$scope.save = function() {
        if (!$scope.sto.stoID) {
            var noviSto = new StoService($scope.sto);
            if (noviSto.brojStola === ""){
                window.alert("Niste popunili polje za redni broj stola.");
            }else{
                noviSto.$save(function(){
                    $scope.stolovi.push(noviSto);
                });
            }
        } else {
            $scope.stolovi.forEach(function(e) {
                if (e.stoID === $scope.sto.stoID) {
                    e.$save({id: e.stoID});
                }
            });
        }
    };*/

    $scope.delete = function(sto) {
        $scope.stolovi.forEach(function(e, index) {
            if (e.stoID == $scope.sto.stoID) {
                $scope.sto.$delete({id: $scope.sto.stoID}, function() {
                    $scope.stolovi.splice(index, 1);
                });
            }
        });
    };

    $scope.orderByField = 'brojStola';
    $scope.reverseSort = false;

});

app.controller('PromeniArtikalListCtrl',function($scope, $location, ArtikalService, KategorijaService, DistributerService) {

    $scope.izmena = function(artikal){
        $scope.artikal = artikal;
        var artikalID = artikal.artikalID;
        sessionStorage.index = artikalID;
    }

    ArtikalService.query({id: sessionStorage.index},function(artikli){
        $scope.artikli = artikli;
    });

    KategorijaService.query(function(kategorije){
        $scope.kategorije = kategorije;
    });

    DistributerService.query(function(distributeri){
        $scope.distributeri = distributeri;
    });

    $scope.izmeniArtikal = function (artikal) {
        if(artikal === 'novi'){
            $scope.noviArtikal = true;
            $scope.artikal = {
                nazivArtikla: "",
                ambalaza: "",
                rokTrajanja: "",
                stanjeNaZalihama: "",
                cena: "",
                distributerID: "",
                kategorijaID: ""
            };
        }
        else {
            $scope.noviArtikal = false;
            $scope.artikal = artikal;
        }
    }


    /*$scope.save = function() {
        if (!$scope.artikal.artikalID) {
            var noviArtikal = new ArtikalService($scope.artikal);
            if (noviArtikal.nazivArtikla === ""
                || noviArtikal.ambalaza===""
                || noviArtikal.rokTrajanja===""
                || noviArtikal.stanjeNaZalihama===""
                || noviArtikal.cena===""
                || noviArtikal.distributerID===""
                || noviArtikal.kategorijaID===""){
                window.alert("Niste popunili sva polja.");
            }else{
                noviArtikal.$save(function(){
                    $scope.artikli.push(noviArtikal);
                });
            }
        }
        else {
            $scope.artikli.forEach(function(e) {
                if (e.artikalID === $scope.artikal.artikalID) {
                    e.$save({id: e.artikalID});
                }
            });
        }
    };*/

    $scope.save = function(artikal){
        artikal.$save({id: artikal.artikalID});
        window.location.href = "#/artikli";
        alert("Podaci su uspesno sacuvani.");
        sessionStorage.removeItem("index");
    }

    $scope.delete = function(artikal) {
        $scope.artikli.forEach(function(e, index) {
            if (e.artikalID === $scope.artikal.artikalID) {
                $scope.artikal.$delete({id: $scope.artikal.artikalID}, function() {
                    $scope.artikli.splice(index, 1);
                });
            }
        });
    };

    $scope.orderByField = 'nazivArtikla';
    $scope.reverseSort = false;
});

app.controller('PromeniDistributeraListCtrl',function($scope, $location, DistributerService) {

    $scope.izmena = function(distributer){
        $scope.distributer = distributer;
        var distributerID = distributer.distributerID;
        sessionStorage.index = distributerID;
    }

    DistributerService.query({id: sessionStorage.index},function(distributeri){
        $scope.distributeri = distributeri;

    });

    $scope.izmeniDistributera = function (distributer) {

        if(distributer === 'novi'){
            $scope.noviDistributer = true;
            $scope.distributer = {
                nazivDistributera: ""
            };
        }
        else {
            $scope.noviDistributer = false;
            $scope.distributer = distributer;
        }
    }

    /*$scope.save = function() {
        if (!$scope.distributer.distributerID) {
            var noviDistributer = new DistributerService($scope.distributer);
            if (noviDistributer.nazivDistributera === ""){
                window.alert("Niste popunili polje za naziv distributera.");
            }else{
                noviDistributer.$save(function(){
                    $scope.distributeri.push(noviDistributer);
                });
            }
        } else {
            $scope.distributeri.forEach(function(e) {
                if (e.distributerID === $scope.distributer.distributerID) {
                    e.$save({id: e.distributerID});
                }
            });
        }
    };*/

    $scope.save = function(distributer){
        distributer.$save({id: distributer.distributerID});
        window.location.href = "#/distributeri";
        alert("Podaci su uspesno sacuvani.");
        sessionStorage.removeItem("index");
    }

    $scope.orderByField = 'nazivDistributera';
    $scope.reverseSort = false;


    $scope.delete = function(distributer) {
        $scope.distributeri.forEach(function(e, index) {
            if (e.distributerID == $scope.distributer.distributerID) {
                $scope.distributer.$delete({id: $scope.distributer.distributerID}, function() {
                    $scope.distributeri.splice(index, 1);
                });
            }
        });
    };

});

app.controller('PromeniKategorijuListCtrl',function($scope, $location, KategorijaService) {

    $scope.izmena = function(kategorija){
        $scope.kategorija = kategorija;
        var kategorijaID = kategorija.kategorijaID;
        sessionStorage.index = kategorijaID;
    }

     KategorijaService.query({id: sessionStorage.index}, function(kategorije){
        $scope.kategorije = kategorije;
     });

    $scope.izmeniKategoriju = function (kategorija) {

        if(kategorija === 'novi'){
            $scope.novaKategorija = true;
            $scope.kategorija = {
                nazivKategorije: ""
            };
        }
        else {
            $scope.novaKategorija = false;
            $scope.kategorija = kategorija;
        }
    }

    $scope.save = function(kategorija){
        kategorija.$save({id: kategorija.kategorijaID});
        window.location.replace("#/kategorije");
        alert("Podaci su uspesno sacuvani.");
        sessionStorage.removeItem("index");
    }

    /*$scope.save = function() {
        if (!$scope.kategorija.kategorijaID) {
            var novaKategorija = new KategorijaService($scope.kategorija);
            if (novaKategorija.nazivKategorije === ""){
                window.alert("Niste popunili polje za naziv kategorije.");
            }else{
                novaKategorija.$save(function(){
                    $scope.kategorije.push(novaKategorija);
                });
            }
        } else {
            $scope.kategorije.forEach(function(e) {
                if (e.kategorijaID === $scope.kategorija.kategorijaID) {
                    e.$save({id: e.kategorijaID});
                }
            });
        }
    };*/

    $scope.delete = function(kategorija) {
        $scope.kategorije.forEach(function(e, index) {
            if (e.kategorijaID == $scope.kategorija.kategorijaID) {
                $scope.kategorija.$delete({id: $scope.kategorija.kategorijaID}, function() {
                    $scope.kategorije.splice(index, 1);
                });
            }
        });
    };

    $scope.orderByField = 'nazivKategorije';
    $scope.reverseSort = false;

});
