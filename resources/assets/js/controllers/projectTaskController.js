angular.module('app.controllers')
    .controller('ProjectTaskListController', ['$scope', '$routeParams', 'ProjectTask', function ($scope, $routeParams, ProjectTask) {
        $scope.tasks = ProjectTask.query({id_project: $routeParams.id_project});
        $scope.page_title = 'Listagem de tarefas do projeto';
    }])
    .controller('ProjectTaskShowController', ['$scope', '$routeParams', 'ProjectTask', function ($scope, $routeParams, ProjectTask) {
        $scope.task = ProjectTask.get({id_project: $routeParams.id_project, id_task: $routeParams.id_task});
        $scope.page_title = 'Tarefa';
    }])
    .controller('ProjectTaskEditController',
    ['$scope', '$location', '$routeParams', 'appConfig', 'ProjectTask', function ($scope, $location, $routeParams, appConfig, ProjectTask) {

        /*$scope.project_task = new ProjectTask.get({
            id_project: $routeParams.id_project,
            id_task: $routeParams.id_task
        });*/
        $scope.page_title = 'Editar tarefa';
        $scope.btn_text = 'Editar';

        ProjectTask.get({
            id_project: $routeParams.id_project,
            id_task: $routeParams.id_task,
        }, function (data) {
            $scope.project_task = data;
        });
        $scope.status = appConfig.project.status;


        //@TODO: Formatar data para o calendário
        //$scope.due_date =

        $scope.due_date = $scope.start_date = {
            status: {
                opened: false,
            }
        };
        $scope.open = function($event){
            $scope.due_date.status.opened = true;
        };
        $scope.open_startDate = function($event){
            $scope.start_date.status.opened = true;
        };

        $scope.update = function () {
            if ($scope.form.$valid) {
                ProjectTask.update({
                    id_project: $routeParams.id_project,
                    id_task: $routeParams.id_task,
                }, $scope.project_task, function () {
                    $location.path('/projetos/' + $routeParams.id_project + '/notas');
                });
            }
        }
    }])
    .controller('ProjectTaskNewController',
    ['$scope', '$location', 'ProjectTask', '$http', 'appConfig', '$routeParams',
        function ($scope, $location, ProjectTask, $http, appConfig, $routeParams) {

            $scope.project_task = new ProjectTask();
            $scope.page_title = 'Cadastrar tarefa';
            $scope.btn_text = 'Cadastrar';
            $scope.status = appConfig.project.status;

            $scope.due_date = {
                status: {
                    opened: false,
                }
            };
            $scope.open = function($event){
                $scope.due_date.status.opened = true;
            };


            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project_task.$save({id_project: $routeParams.id_project}).then(function () {
                        $location.path('/projetos/' + $routeParams.id_project + '/tasks');
                    });
                }
            }

        }])
    .controller('ProjectTaskDeleteController',
    ['$scope', '$location', '$routeParams', 'ProjectTask', function ($scope, $location, $routeParams, ProjectTask) {
        $scope.project_task = new ProjectTask.get({
            id_project: $routeParams.id_project,
            id_task: $routeParams.id_task
        });

        $scope.page_title = 'Deletar nota';
        $scope.btn_text = 'Deletar';

        $scope.delete = function () {
            $scope.project_task.$delete({
                id_project: $scope.project_task.project_id,
                id_task: $scope.project_task.id,
            }).then(function () {
                $location.path('/projetos/' + $routeParams.id_project + '/notas');
            });
        }
    }])
