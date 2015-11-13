angular.module('app.controllers')
    .controller('ClientListController', ['$rootScope', '$scope', 'Client',
        function ($rootScope, $scope, Client) {
            //$rootScope.page_title = 'Clientes';
            $scope.clients = Client.query({},
                function (data) {
                    $scope.clients = data.data;
                    //$scope.totalProjects = data.meta.pagination.total;
                    //console.log($scope.projects, $scope.totalProjects);
                    //console.log($scope.projects);
                });
        }])
    .controller('ClientShowController', ['$rootScope', '$scope', '$routeParams', 'Client',
        function ($rootScope, $scope, $routeParams, Client) {
            //$rootScope.page_title = 'Cliente';

            $scope.client = Client.get({id: $routeParams.id});
            $scope.btn_delete = 'Deletar';
        }])
    .controller('ClientNewController',
    ['$rootScope', '$scope', '$location', '$modal', 'Client',
        function ($rootScope, $scope, $location, $modal, Client) {
            //$rootScope.page_title = 'Novo cliente';

            $scope.client = new Client();

            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.client.$save().then(function () {
                        $location.path('/clientes');
                    }, function(error){
                        $scope.errors = error.data.mensagens;

                        $scope.close = function(){
                            modalInstance.close()
                        }

                        var modalInstance = $modal.open({
                            templateUrl: 'build/views/templates/error-modal.html',
                            scope: $scope,
                        });

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
    }])
    .controller('ClientDashboardController',
    ['$rootScope', '$scope', '$location', '$routeParams', 'Client',
        function ($rootScope, $scope, $location, $routeParams, Client) {
            //$rootScope.page_title = 'Editar ciente';

            $scope.client = {};

            $scope.clients = Client.query({
                orderBy: 'created_at',
                sortedBy: 'desc',
                limit: 8,
            }, function (response) {
                $scope.clients = response.data;
            });

            $scope.showClient = function (client) {
                $scope.client = client;
            };
        }]);