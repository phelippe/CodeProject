angular.module('app.controllers')
    .controller('ProjectNoteListController', ['$scope', '$routeParams','ProjectNote', function ($scope, $routeParams, ProjectNote) {
        $scope.notes = ProjectNote.query({id_project: $routeParams.id_project});
    }]);