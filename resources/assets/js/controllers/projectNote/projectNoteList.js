angular.module('app.controllers')
    .controller('ProjectNoteListController', ['$scope', '$routeParams','ProjectNote', function ($scope, $routeParams, ProjectNote) {
        $scope.notes = ProjectNote.query({id_project: $routeParams.id_project});
        $scope.page_title = 'Listagem de notas de projeto';
    }]);