/**
 * Created by milos on 5/11/16.
 */

Dictionary.controller('TranslationFormController', ['$scope', '$http', 'HistoryService',
    function ($scope, $http, HistoryService) {

        $scope.errorMessage = null;


        $scope.translate = function() {
            $http.get('/api/v1/translation/' + $scope.word).success(function(data) {
                var historyObject = {};

                $scope.result = data.translations;

                historyObject.word = $scope.word;
                historyObject.translations = {};

                for(var i in data.translations) {
                    var translationPerType = [];
                    for (var j in data.translations[i]) {
                        translationPerType.push(data.translations[i][j]['translation']);
                    }
                    historyObject.translations[i] = translationPerType;
                }

                HistoryService.addHistoryItem(historyObject);

                $http.get('app_dev.php/api/v1/history/' + $scope.word + '/update').success(function(data) {
                    console.log('history');
                });
            });
        };

        $scope.translateSynonym = function(word) {
            $http.get('/api/v1/translation/' + word).success(function(data) {
                if(!$scope.result) {
                   $scope.errorMessage = "There is no results";
                }
                $scope.word = word;
                $scope.result = data.translation;
            });
        };
    }
]);