angular.module('app.controllers')
    .controller('ProjectListController', [
        '$scope', '$routeParams', 'Project', function ($scope, $routeParams, Project) {
            $scope.page_title = 'Listagem de projetos';

            $scope.projects = [];
            $scope.totalProjects = 0;
            $scope.projectsPerPage = 3;

            $scope.pagination = {
                current: 1
            };

            $scope.pageChanged = function (newPage) {
                getResultsPage(newPage);
            };

            function getResultsPage(pageNumber) {
                $scope.projects = Project.query({
                    page: pageNumber,
                    limit: $scope.projectsPerPage,
                }, function (data) {
                    $scope.projects = data.data;
                    $scope.totalProjects = data.meta.pagination.total;
                });
            }

            getResultsPage(1);

        }])
    .controller('ProjectShowController', ['$scope', '$routeParams', 'Project', function ($scope, $routeParams, Project) {
        $scope.project = Project.get({id_project: $routeParams.id_project});
        $scope.page_title = 'Projeto';
    }])
    .controller('ProjectEditController',
    ['$scope', '$location', '$routeParams', 'Project', 'Client', 'appConfig', function ($scope, $location, $routeParams, Project, Client, appConfig) {

        $scope.page_title = 'Editar projeto';
        $scope.btn_text = 'Editar';

        Project.get({
            id_project: $routeParams.id_project,
        }, function (data) {
            $scope.project = data;
            $scope.client_selected = data.client.data;
        });
        //$scope.clients = Client.query();
        $scope.status = appConfig.project.status;

        $scope.formatName = function (model) {
            if (model) {
                return model.name;
            }
            return '';
        }

        $scope.getClients = function (name) {
            return Client.query({
                search: name,
                searchFields: 'name:like',
            }).$promise;
        }

        $scope.selectClient = function (item) {
            $scope.project.client_id = item.id;
        }

        $scope.update = function () {
            if ($scope.form.$valid) {
                Project.update({
                    id_project: $routeParams.id_project,
                }, $scope.project, function () {
                    $location.path('/projetos');
                });
            }
        }

    }])
    .controller('ProjectNewController',
    ['$scope', '$location', 'Project', '$http', 'appConfig', '$routeParams', 'Client', 'User', '$cookies',
        function ($scope, $location, Project, $http, appConfig, $routeParams, Client, User, $cookies) {

            $scope.project = new Project();
            $scope.status = appConfig.project.status;

            $scope.page_title = 'Novo projeto';
            $scope.btn_text = 'Cadastrar';

            $scope.due_date = {
                status: {
                    opened: false,
                }
            };
            $scope.open = function ($event) {
                $scope.due_date.status.opened = true;
            };


            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project.owner_id = $cookies.getObject('user').id;
                    $scope.project.$save({}).then(function () {
                        $location.path('/projetos');
                    });
                }
            }

            $scope.formatName = function (model) {
                if (model) {
                    return model.name;
                }
                return '';
            }

            $scope.getClients = function (name) {
                return Client.query({
                    search: name,
                    searchFields: 'name:like',
                }).$promise;
            }

            $scope.selectClient = function (item) {
                $scope.project.client_id = item.id;
            }

        }])
    .controller('ProjectDeleteController',
    ['$scope', '$location', '$routeParams', 'Project', function ($scope, $location, $routeParams, Project) {
        $scope.project = new Project.get({
            id_project: $routeParams.id_project,
        });

        $scope.page_title = 'Deletar projeto';
        $scope.btn_text = 'Deletar';

        $scope.delete = function () {
            //console.log($scope.project);
            //$scope.project.id no lugar de $scope.project.project_id, pq tem que refatorar o presenter de usuário
            $scope.project.$delete({id_project: $scope.project.id}).then(function () {
                $location.path('/projetos');
            });
        }
    }])
