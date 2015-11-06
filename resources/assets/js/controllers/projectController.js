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
                //console.log(newPage);
                getResultsPage(newPage);
            };

            function getResultsPage(pageNumber) {
                $scope.projects = Project.query({
                    page: pageNumber,
                    limit: $scope.projectsPerPage,
                }, function (data) {
                    $scope.projects = data.data;
                    $scope.totalProjects = data.meta.pagination.total;
                    //console.log($scope.projects, $scope.totalProjects);
                });
            }

            getResultsPage(1);

        }])
    .controller('ProjectListAsMemberController', [
        '$scope', '$routeParams', 'appConfig', 'Project', function ($scope, $routeParams, appConfig, Project) {
            $scope.page_title = 'Listagem de projetos na qual <strong>VOCÊ É MEMBRO</strong>';

            $scope.projects = [];
            $scope.totalProjects = 0;
            $scope.projectsPerPage = 10;

            $scope.pagination = {
                current: 1
            };

            $scope.pageChanged = function (newPage) {
                //console.log(newPage);
                getResultsPage(newPage);
            };


            function getResultsPage(pageNumber) {
                $scope.projects = Project.queryAsMember({
                    page: pageNumber,
                    limit: $scope.projectsPerPage,
                }, function (data) {
                    $scope.projects = data.data;
                    $scope.totalProjects = data.meta.pagination.total;
                    //console.log($scope.projects, $scope.totalProjects);
                    //console.log($scope.projects);
                });
            }

            getResultsPage(1);

        }])
    .controller('ProjectShowController', ['$scope', '$routeParams', '$location', '$modal', 'Project', function ($scope, $routeParams, $location, $modal, Project) {
        Project.get({
            id_project: $routeParams.id_project,
            //with: 'client,owner',
        }, function (data) {
            //console.log('success');
            $scope.project = data;
        }, function (data) {
            //$scope.mensagem = data;
            $scope.mensagem = 'Você não tem permissão para acessar';
            $scope.close = function(){
                //modalInstance.close()
                $location.path('projetos');
            }

            var modalInstance = $modal.open({
                templateUrl: 'build/views/templates/error-modal.html',
                scope: $scope,
            });

            /*console.log('não pode acessar projeto');
             alert('chamar a modal aqui e redirecionar para listagem ao clicar em OK');*/
        });

        $scope.cancel_modal = function () {
            $location.path('projetos');
        }
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
    .controller('ProjectDashboardController',
    ['$scope', '$location', '$routeParams', 'Project',
        function ($scope, $location, $routeParams, Project) {

            $scope.page_title = 'Dashboard';

            $scope.project = {};

            $scope.projects = Project.query({
                orderBy: 'created_at',
                sortedBy: 'desc',
                limit: 5,
            }, function (response) {
                $scope.projects = response.data;
            });

            $scope.showProject = function (project) {
                $scope.project = project;
            }
        }]);
