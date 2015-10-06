angular.module('app.controllers')
    .controller('ProjectMemberListController', ['$scope', '$routeParams', 'ProjectMember', function ($scope, $routeParams, ProjectMember) {
        $scope.members = ProjectMember.query({id_project: $routeParams.id_project});
        $scope.page_title = 'Listagem de membros de projeto';
    }])
    .controller('ProjectMemberShowController', ['$scope', '$routeParams', 'ProjectMember', function ($scope, $routeParams, ProjectMember) {
        $scope.member = ProjectMember.get({id_project: $routeParams.id_project, id_member: $routeParams.id_member});
        $scope.page_title = 'Nota';
    }])
    .controller('ProjectMemberEditController',
    ['$scope', '$location', '$routeParams', 'ProjectMember', function ($scope, $location, $routeParams, ProjectMember) {
        $scope.project_member = new ProjectMember.get({
            id_project: $routeParams.id_project,
            id_member: $routeParams.id_member
        });
        $scope.page_title = 'Editar membro';
        $scope.btn_text = 'Editar';

        $scope.update = function () {
            if ($scope.form.$valid) {
                ProjectMember.update({
                    id_project: $routeParams.id_project,
                    id_member: $routeParams.id_member,
                }, $scope.project_member, function () {
                    $location.path('/projetos/' + $routeParams.id_project + '/membros');
                });
            }
        }
    }])
    .controller('ProjectMemberNewController',
    ['$scope', '$location', 'ProjectMember', '$http', 'appConfig', '$routeParams',
        function ($scope, $location, ProjectMember, $http, appConfig, $routeParams) {

            $scope.project_member = new ProjectMember();
            $scope.page_title = 'Cadastrar membro';
            $scope.btn_text = 'Cadastrar';


            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project_member.$save({id_project: $routeParams.id_project}).then(function () {
                        $location.path('/projetos/' + $routeParams.id_project + '/membros');
                    });
                }
            }

        }])
    .controller('ProjectMemberDeleteController',
    ['$scope', '$location', '$routeParams', 'ProjectMember', function ($scope, $location, $routeParams, ProjectMember) {
        $scope.project_member = new ProjectMember.get({
            id_project: $routeParams.id_project,
            id_member: $routeParams.id_member
        });

        $scope.page_title = 'Deletar membro';
        $scope.btn_text = 'Deletar';

        $scope.delete = function () {
            $scope.project_member.$delete({
                id_project: $scope.project_member.project_id,
                id_member: $scope.project_member.id,
            }).then(function () {
                $location.path('/projetos/' + $routeParams.id_project + '/membros');
            });
        }
    }])
