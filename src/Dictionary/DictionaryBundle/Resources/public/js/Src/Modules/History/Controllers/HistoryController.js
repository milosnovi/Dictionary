/**
 * Created by milos on 5/11/16.
 */

Dictionary.controller('HistoryController', ['$scope', '$http', 'HistoryService',
    function ($scope, $http, HistoryService) {

        $http.get('/app_dev.php/api/v1/user/history').success(function(data) {
            HistoryService.setData(data);
            $scope.history = HistoryService.getData();
        });
    }
]);