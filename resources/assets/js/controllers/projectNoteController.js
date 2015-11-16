angular.module('app.controllers')
    .controller('ProjectNoteListController', ['$scope', '$routeParams', '$compile', '$http', '$timeout', '$window', 'ProjectNote',
        function ($scope, $routeParams, $compile, $http, $timeout, $window, ProjectNote) {
        $scope.notes = ProjectNote.query({id_project: $routeParams.id_project});
        $scope.page_title = 'Listagem de notas de projeto';

        $scope.print = function (note) {
            $http.get('/build/views/templates/projectNoteShow.html').then(function (response) {
                $scope.note = note;
                var div = $('<div/>');
                div.html($compile(response.data)($scope));
                $timeout(function(){
                    var frame = $window.open('', '_blank', 'width=500, height=500');
                    frame.document.open();
                    frame.document.write(div.html());
                    frame.document.close();
                });
            });
        }

    }])
    .controller('ProjectNoteShowController', ['$scope', function ($scope) {
        //$scope.page_title = 'Nota';
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
                    $location.path('/projetos/' + $routeParams.id_project + '/notas');
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
                        $location.path('/projetos/' + $routeParams.id_project + '/notas');
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
                $location.path('/projetos/' + $routeParams.id_project + '/notas');
            });
        }
    }])
