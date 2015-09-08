angular.module('app.controllers')
    .controller('ProjectNoteNewController',
    ['$scope', '$location', 'ProjectNote', '$http', 'appConfig', function ($scope, $location, ProjectNote, $http, appConfig) {

        $scope.project_note = new ProjectNote();
        $scope.page_title = 'Cadastrar nota';
        $scope.btn_text = 'Cadastrar';


        /*$scope.save = function () {
             if($scope.form.$valid){
                 $scope.project_note.$save().then(function () {
                    $location.path('/project/:id_project/notes');
                 });
             }
         }*/

        $scope.save = function (project_note) {
            if ($scope.form.$valid) {
                console.log($scope.project_note);
                $http.post(appConfig.baseUrl + '/project/:id_project/notes', project_note)
                    .success(function (data) {
                        console.log(data);
                        $location.path('/project/:id_project/notes');
                    })
                    .error(function (data) {
                        console.log(data);
                    });
            }
        }
    }]);