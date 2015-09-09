angular.module('app.controllers')
    .controller('ProjectNoteListController', ['$scope', '$routeParams', 'ProjectNote', function ($scope, $routeParams, ProjectNote) {
        $scope.notes = ProjectNote.query({id_project: $routeParams.id_project});
        $scope.page_title = 'Listagem de notas de projeto';
    }])
    .controller('ProjectNoteShowController', ['$scope', '$routeParams', 'ProjectNote', function ($scope, $routeParams, ProjectNote) {
        $scope.note = ProjectNote.get({id_project: $routeParams.id_project, id_note: $routeParams.id_note});
        $scope.page_title = 'Nota';
    }])
    .controller('ProjectNoteEditController',
    ['$scope', '$location', '$routeParams', 'ProjectNote', function ($scope, $location, $routeParams, ProjectNote) {
        $scope.project_note = new ProjectNote.get({
            id_project: $routeParams.id_project,
            id_note: $routeParams.id_note
        });
        $scope.page_title = 'Editar nota';
        $scope.btn_text = 'Editar';

        $scope.update = function () {
            if ($scope.form.$valid) {
                ProjectNote.update({
                    id_project: $routeParams.id_project,
                    id_note: $routeParams.id_note,
                }, $scope.project_note, function () {
                    $location.path('/project/' + $routeParams.id_project + '/notes');
                });
            }
        }
    }])
    .controller('ProjectNoteNewController',
    ['$scope', '$location', 'ProjectNote', '$http', 'appConfig', '$routeParams',
        function ($scope, $location, ProjectNote, $http, appConfig, $routeParams) {

            $scope.project_note = new ProjectNote();
            $scope.page_title = 'Cadastrar nota';
            $scope.btn_text = 'Cadastrar';


            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project_note.$save({id_project: $routeParams.id_project}).then(function () {
                        $location.path('/project/' + $routeParams.id_project + '/notes');
                    });
                }
            }

        }])
    .controller('ProjectNoteDeleteController',
    ['$scope', '$location', '$routeParams', 'ProjectNote', function ($scope, $location, $routeParams, ProjectNote) {
        $scope.project_note = new ProjectNote.get({
            id_project: $routeParams.id_project,
            id_note: $routeParams.id_note
        });

        $scope.page_title = 'Deletar nota';
        $scope.btn_text = 'Deletar';

        $scope.delete = function () {
            $scope.project_note.$delete({
                id_project: $scope.project_note.project_id,
                id_note: $scope.project_note.id,
            }).then(function () {
                $location.path('/project/' + $routeParams.id_project + '/notes');
            });
        }
    }])
