'use strict';

/* App Module */

var Dictionary = angular.module('Dictionary', ['ngRoute']);

Dictionary.config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {

        $routeProvider.when('/', {
            templateUrl: 'bundles/dictionary/js/Src/Views/home.view.html'
        }).otherwise({
            redirectTo: '/'
        })
        ;

        $locationProvider.html5Mode({
            enabled: true
        });
    }
]);