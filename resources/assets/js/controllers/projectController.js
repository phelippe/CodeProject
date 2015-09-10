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
    ['$scope', '$location', '$routeParams', 'Project', 'Client', 'appConfig', function ($scope, $location, $routeParams, Project, Client, appConfig) {
        $scope.project = new Project.get({
            id_project: $routeParams.id_project,
            id_project: $routeParams.id_project
        });
        $scope.clients = Client.query();
        $scope.status = appConfig.project.status;

        $scope.page_title = 'Editar projeto';
        $scope.btn_text = 'Editar';

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
            $scope.clients = Client.query();
            $scope.status = appConfig.project.status;
            //$scope.users = User.query();
            //console.log($cookies.getObject('user').id);

            $scope.page_title = 'Novo projeto';
            $scope.btn_text = 'Cadastrar';


            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project.owner_id = $cookies.getObject('user').id;
                    $scope.project.$save({}).then(function () {
                        $location.path('/projetos');
                    });
                }
            }

            $scope.formatName = function(id) {
                console.log(id);
                if(id){
                    for(var i in $scope.clients){
                        if($scope.clients[i].id == id){
                            return $scope.clients[i].name;
                        }
                    }
                }
                return '';
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
