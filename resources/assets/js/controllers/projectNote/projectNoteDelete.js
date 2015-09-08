angular.module('app.controllers')
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
    }]);