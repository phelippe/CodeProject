angular.module('app.controllers')
    .controller('ClientListController', ['$rootScope', '$scope', 'Client',
        function ($rootScope, $scope, Client) {
            //$rootScope.page_title = 'Clientes';
            $scope.clients = Client.query();
        }])
    .controller('ClientShowController', ['$rootScope', '$scope', '$routeParams', 'Client',
        function ($rootScope, $scope, $routeParams, Client) {
            //$rootScope.page_title = 'Cliente';

            $scope.client = Client.get({id: $routeParams.id});
            $scope.btn_delete = 'Deletar';
        }])
    .controller('ClientNewController',
    ['$rootScope', '$scope', '$location', 'Client',
        function ($rootScope, $scope, $location, Client) {
            //$rootScope.page_title = 'Novo cliente';

            $scope.client = new Client();

            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.client.$save().then(function () {
                        $location.path('/clientes');
                    });
                }
            }
        }])
    .controller('ClientDeleteController',
    ['$rootScope', '$scope', '$location', '$routeParams', 'Client',
        function ($rootScope, $scope, $location, $routeParams, Client) {
            //$rootScope.page_title = 'Deletar cliente';
            $scope.client = new Client.get({id: $routeParams.id});

            $scope.delete = function () {
                $scope.client.$delete().then(function () {
                    $location.path('/clientes');
                });
            }
        }])
    .controller('ClientEditController',
    ['$rootScope', '$scope', '$location', '$routeParams', 'Client', function ($rootScope, $scope, $location, $routeParams, Client) {
        //$rootScope.page_title = 'Editar ciente';

        $scope.client = Client.get({id: $routeParams.id});

        $scope.update = function () {
            if ($scope.form.$valid) {
                Client.update({id: $scope.client.id}, $scope.client, function () {
                    $location.path('/clientes');
                });
            }
        }
    }]);