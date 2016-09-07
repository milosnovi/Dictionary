'use strict';

/* App Module */

var Dictionary = angular.module('Dictionary', ['ngRoute']);

Dictionary.config(['$routeProvider', function($routeProvider) {
    $routeProvider.
        when('/', {
            templateUrl: 'bundles/dictionary/js/Src/Views/home.view.html',
        }).
        otherwise({
            redirectTo: '/'
        });
    }
]);