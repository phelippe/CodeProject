angular.module('app.controllers')
    .controller('ProjectTaskListController', ['$scope', '$routeParams', 'appConfig', 'ProjectTask',
        function ($scope, $routeParams, appConfig, ProjectTask) {
            $scope.page_title = 'Listagem de tarefas do projeto';
            $scope.project_task = new ProjectTask();

            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project_task.status = appConfig.projectTask.status[0].value;
                    $scope.project_task.$save({
                            id_project: $routeParams.id_project
                        }
                    ).then(function () {
                            $scope.project_task = new ProjectTask();
                            $scope.loadTask();
                        });
                }
            };

            $scope.loadTask = function () {
                $scope.project_tasks = ProjectTask.query({
                    id_project: $routeParams.id_project,
                    orderBy: 'id',
                    sortedBy: 'desc',
                });
            }
            $scope.loadTask();

        }])
    .controller('ProjectTaskNewController',
    ['$scope', '$location', 'ProjectTask', '$http', 'appConfig', '$routeParams',
        function ($scope, $location, ProjectTask, $http, appConfig, $routeParams) {

            $scope.project_task = new ProjectTask();
            $scope.page_title = 'Cadastrar tarefa';
            $scope.btn_text = 'Cadastrar';
            $scope.status = appConfig.projectTask.status;

            $scope.due_date = {
                status: {
                    opened: false,
                }
            };
            $scope.start_date = {
                status: {
                    opened: false,
                }
            };
            $scope.open = function ($event) {
                $scope.due_date.status.opened = true;
            };
            $scope.open_startDate = function ($event) {
                $scope.start_date.status.opened = true;
            };


            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project_task.$save({id_project: $routeParams.id_project}).then(function () {
                        $location.path('/projetos/' + $routeParams.id_project + '/tarefas');
                    });
                }
            }

        }])
    /*.controller('ProjectTaskShowController', ['$scope', '$routeParams', 'ProjectTask', function ($scope, $routeParams, ProjectTask) {
     $scope.task = ProjectTask.get({id_project: $routeParams.id_project, id_task: $routeParams.id_task});
     $scope.page_title = 'Tarefa';
     }])*/
    .controller('ProjectTaskEditController',
    ['$scope', '$location', '$routeParams', 'appConfig', 'ProjectTask', '$filter',
        function ($scope, $location, $routeParams, appConfig, ProjectTask, $filter) {

        $scope.page_title = 'Editar tarefa';
        $scope.btn_text = 'Editar';

        $scope.due_date = {
            status: {
                opened: false,
            }
        };
        $scope.start_date = {
            status: {
                opened: false,
            }
        };
        $scope.open = function ($event) {
            $scope.due_date.status.opened = true;
        };
        $scope.open_startDate = function ($event) {
            $scope.start_date.status.opened = true;
        };

        ProjectTask.get({
            id_project: $routeParams.id_project,
            id_task: $routeParams.id_task,
        }, function (data) {
            $scope.project_task = data;
            //$scope.project_task.start_date = $filter('date')(Date.parse($scope.project_task.start_date), 'dd/MM/yyyy');
            //$scope.project_task.due_date = $filter('date')(Date.parse($scope.project_task.due_date), 'dd/MM/yyyy');
        });
        $scope.status = appConfig.projectTask.status;

        $scope.update = function () {
            if ($scope.form.$valid) {
                ProjectTask.update({
                    id_project: $routeParams.id_project,
                    id_task: $routeParams.id_task,
                }, $scope.project_task, function () {
                    $location.path('/projetos/' + $routeParams.id_project + '/tarefas');
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
                $location.path('/projetos/' + $routeParams.id_project + '/tarefas');
            });
        }
    }])
