angular.module('app.controllers')
    .controller('ProjectFileListController', ['$scope', '$routeParams', 'ProjectFile', function ($scope, $routeParams, ProjectFile) {
        $scope.project_files = ProjectFile.query({id_project: $routeParams.id_project});
        $scope.page_title = 'Listagem de arquivos de projeto';
    }])
    .controller('ProjectFileShowController', ['$scope', '$routeParams', 'ProjectFile', function ($scope, $routeParams, ProjectFile) {
        $scope.file = ProjectFile.get({id_project: $routeParams.id_project, id_file: $routeParams.id_file});
        $scope.page_title = 'Arquivos';
    }])
    .controller('ProjectFileEditController',
    ['$scope', '$location', '$routeParams', 'ProjectFile', function ($scope, $location, $routeParams, ProjectFile) {
        $scope.project_file = new ProjectFile.get({
            id_project: $routeParams.id_project,
            id_file: $routeParams.id_file
        });
        $scope.page_title = 'Editar arquivo';
        $scope.btn_text = 'Editar';

        $scope.update = function () {
            if ($scope.form.$valid) {
                ProjectFile.update({
                    id_project: $routeParams.id_project,
                    id_file: $routeParams.id_file,
                }, $scope.project_file, function () {
                    $location.path('/project/' + $routeParams.id_project + '/file');
                });
            }
        }
    }])
    .controller('ProjectFileNewController',
    ['$scope', '$location', /*'ProjectFile', '$http', */'appConfig', '$routeParams', 'Upload', 'Url',
        function ($scope, $location, /*ProjectFile, $http, */appConfig, $routeParams, Upload, Url) {

            //$scope.project_file = new ProjectFile();
            $scope.page_title = 'Cadastrar arquivo';
            $scope.btn_text = 'Cadastrar';

            /*console.log(Url.getUrlResource('/projetos/{{id_project}}/file/{{id_file}}'));
             console.log(Url.getUrlFromUrlSymbol('/projetos/{{id_project}}/file/{{id_file}}', {id_project: 7, id_file: 10}));
             console.log(Url.getUrlFromUrlSymbol('/projetos/{{id_project}}/file/{{id_file}}', {id_project: '', id_file: 10}));
             console.log(Url.getUrlFromUrlSymbol('/projetos/{{id_project}}/file/{{id_file}}', {id_project: 7, id_file: ''}));*/

            $scope.save = function () {
                if ($scope.form.$valid) {
                    //$scope.upload = function (file) {
                    var url = appConfig.baseUrl +
                        Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {
                            id_project: $routeParams.id_project,
                            id_file: $routeParams.id_file
                        });
                    Upload.upload({
                        //url: 'upload/url',
                        url: url,
                        fields: {
                            project_id: $routeParams.id_project,
                            name: $scope.project_file.name,
                            description: $scope.project_file.description,
                        },
                        file: $scope.project_file.file,
                    }).success(function (data, status, headers, config) {
                        $location.path('/projetos/' + $routeParams.id_project + '/files');
                        //console.log('file ' + config.file.name + 'uploaded. Response: ' + data);
                    });
                    //};

                    /*$scope.project_file.$save({id_project: $routeParams.id_project}).then(function () {
                     $location.path('/project/' + $routeParams.id_project + '/file');
                     });*/
                }
            }

        }])
    .controller('ProjectFileDeleteController',
    ['$scope', '$location', '$routeParams', 'ProjectFile', function ($scope, $location, $routeParams, ProjectFile) {
        $scope.project_file = new ProjectFile.get({
            id_project: $routeParams.id_project,
            id_file: $routeParams.id_file
        });

        $scope.page_title = 'Deletar arquivo';
        $scope.btn_text = 'Deletar';

        $scope.delete = function () {
            $scope.project_file.$delete({
                id_project: $scope.project_file.project_id,
                id_file: $scope.project_file.id,
            }).then(function () {
                $location.path('/project/' + $routeParams.id_project + '/file');
            });
        }
    }])
