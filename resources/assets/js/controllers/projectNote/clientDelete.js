angular.module('app.controllers')
    .controller('ClientDeleteController',
    ['$scope', '$location', '$routeParams', 'Client', function ($scope, $location, $routeParams, Client) {
        $scope.client = new Client.get({id: $routeParams.id});

        $scope.delete = function () {
            $scope.client.$delete().then(function(){
                $location.path('/clientes');
            });
        }
    }]);