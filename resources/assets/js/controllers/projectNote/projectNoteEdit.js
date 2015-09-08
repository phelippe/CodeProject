angular.module('app.controllers')
    .controller('ProjectNoteEditController',
    ['$scope', '$location', '$routeParams', 'ProjectNote', function ($scope, $location, $routeParams, ProjectNote) {
        $scope.project_note = new ProjectNote.get({
            id_project: $routeParams.id_project,
            id_note: $routeParams.id_note
        });
        $scope.page_title = 'Editar nota';

        $scope.update = function () {
            if($scope.form.$valid){
                ProjectNote.update({id: $scope.project_note.id_note}, $scope.project_note, function(){
                    $location.path('/clientes');
                });
            }
            /*if ($scope.form.$valid) {
                $scope.project_note.$save({id_project: $routeParams.id_project}).then(function () {
                    $location.path('/project/'+ $routeParams.id_project +'/notes');
                });
            }*/
        }
    }]);