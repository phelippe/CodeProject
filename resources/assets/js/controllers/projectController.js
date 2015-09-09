angular.module('app.controllers')
    .controller('ProjectListController', ['$scope', '$routeParams', 'Project', function ($scope, $routeParams, Project) {
        $scope.projects = Project.query();
        $scope.page_title = 'Listagem de projetos';
    }])
    .controller('ProjectShowController', ['$scope', '$routeParams', 'Project', function ($scope, $routeParams, Project) {
        $scope.project = Project.get({id_project: $routeParams.id_project});
        $scope.page_title = 'Projeto';
    }])
    .controller('ProjectEditController',
    ['$scope', '$location', '$routeParams', 'Project', function ($scope, $location, $routeParams, Project) {
        $scope.project_project = new Project.get({
            id_project: $routeParams.id_project,
            id_project: $routeParams.id_project
        });
        $scope.page_title = 'Editar projeto';
        $scope.btn_text = 'Editar';

        $scope.update = function () {
            if ($scope.form.$valid) {
                Project.update({
                    id_project: $routeParams.id_project,
                    id_project: $routeParams.id_project,
                }, $scope.project_project, function () {
                    $location.path('/project/' + $routeParams.id_project + '/projects');
                });
            }
        }
    }])
    .controller('ProjectNewController',
    ['$scope', '$location', 'Project', '$http', 'appConfig', '$routeParams',
        function ($scope, $location, Project, $http, appConfig, $routeParams) {

            $scope.project_project = new Project();
            $scope.page_title = 'Cadastrar projeto';
            $scope.btn_text = 'Cadastrar';


            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project_project.$save({id_project: $routeParams.id_project}).then(function () {
                        $location.path('/project/' + $routeParams.id_project + '/projects');
                    });
                }
            }

        }])
    .controller('ProjectDeleteController',
    ['$scope', '$location', '$routeParams', 'Project', function ($scope, $location, $routeParams, Project) {
        $scope.project_project = new Project.get({
            id_project: $routeParams.id_project,
            id_project: $routeParams.id_project
        });

        $scope.page_title = 'Deletar projeto';
        $scope.btn_text = 'Deletar';

        $scope.delete = function () {
            $scope.project_project.$delete({
                id_project: $scope.project_project.project_id,
                id_project: $scope.project_project.id,
            }).then(function () {
                $location.path('/project/' + $routeParams.id_project + '/projects');
            });
        }
    }])
