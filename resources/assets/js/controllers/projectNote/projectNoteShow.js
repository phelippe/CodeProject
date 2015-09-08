angular.module('app.controllers')
    .controller('ProjectNoteShowController', ['$scope', '$routeParams','ProjectNote', function ($scope, $routeParams, ProjectNote) {
        $scope.note = ProjectNote.get({id_project: $routeParams.id_project, id_note: $routeParams.id_note});
        $scope.page_title = 'Nota';
    }]);