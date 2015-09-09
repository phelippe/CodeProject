angular.module('app.controllers')
    .controller('ClientListController', ['$scope', 'Client', function ($scope, Client) {
        $scope.clients = Client.query();
    }])
    .controller('ClientShowController', ['$scope', '$routeParams', 'Client', function ($scope, $routeParams, Client) {
        $scope.client = Client.get({id: $routeParams.id});
        $scope.page_title = 'Cliente';
        $scope.btn_delete = 'Deletar';
    }])
    .controller('ClientNewController',
    ['$scope', '$location', 'Client', function ($scope, $location, Client) {
        $scope.client = new Client();

        $scope.save = function () {
            if($scope.form.$valid){
                $scope.client.$save().then(function () {
                    $location.path('/clientes');
                });
            }
        }
    }])
    .controller('ClientDeleteController',
    ['$scope', '$location', '$routeParams', 'Client', function ($scope, $location, $routeParams, Client) {
        $scope.client = new Client.get({id: $routeParams.id});

        $scope.delete = function () {
            $scope.client.$delete().then(function(){
                $location.path('/clientes');
            });
        }
    }])
    .controller('ClientEditController',
    ['$scope', '$location', '$routeParams', 'Client', function ($scope, $location, $routeParams, Client) {
        $scope.client = new Client.get({id: $routeParams.id});

        $scope.update = function () {
            if($scope.form.$valid){
                Client.update({id: $scope.client.id}, $scope.client, function(){
                    $location.path('/clientes');
                });
            }
        }
    }]);