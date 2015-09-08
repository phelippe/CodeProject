angular.module('app.controllers')
    .controller('ProjectNoteNewController',
    ['$scope', '$location', 'ProjectNote', '$http', 'appConfig', '$routeParams',
        function ($scope, $location, ProjectNote, $http, appConfig, $routeParams) {

        $scope.project_note = new ProjectNote();
        $scope.page_title = 'Cadastrar nota';
        $scope.btn_text = 'Cadastrar';


        $scope.save = function () {
            if ($scope.form.$valid) {
                $scope.project_note.$save({id_project: $routeParams.id_project}).then(function () {
                    $location.path('/project/'+ $routeParams.id_project +'/notes');
                });
            }
        }

    }]);