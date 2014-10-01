var config = require('../Konekcija.php')
  , db = require('kafic')({url: '../Konekcija.php'})

  , loggedInUsers = {}

  , addLoggedInUser = exports.addLoggedInUser = function(authSession, konobar) {
      loggedInUsers[authSession] = konobar;
    }

  , getLoggedInUser = exports.getLoggedInUser = function(authSession) {
      return loggedInUsers[authSession]
    }

  , removeLoggedInUser = exports.removeLoggedInUser = function(authSession) {
      delete loggedInUsers[authSession]
    }
  
  , login = exports.login = function(korisnickoIme, korisnickaSifra, callback) {
      db.auth(korisnickoIme, korisnickaSifra, function (err, body, headers) {
        if (err) { 
          return callback(err);
        }
        var cookie = headers['set-cookie'][0];
        var authSession = cookie.split(';')[0].split('=')[1];
        addLoggedInUser(authSession, username);
        callback(null, cookie);
      });
    };
