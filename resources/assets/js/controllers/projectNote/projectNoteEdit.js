angular.module('app.controllers')
    .controller('ProjectNoteEditController',
    ['$scope', '$location', '$routeParams', 'ProjectNote', function ($scope, $location, $routeParams, ProjectNote) {
        $scope.project_note = new ProjectNote.get({
            id_project: $routeParams.id_project,
            id_note: $routeParams.id_note
        });
        $scope.page_title = 'Editar nota';
        $scope.btn_text = 'Editar';

        $scope.update = function () {
            if($scope.form.$valid){
                ProjectNote.update({
                    id_project: $routeParams.id_project,
                    id_note: $routeParams.id_note,
                }, $scope.project_note, function(){
                    $location.path('/project/'+ $routeParams.id_project +'/notes');
                });
            }
        }
    }]);