angular.module('app.controllers')
    .controller('ProjectMemberListController', [
        '$scope', '$routeParams', 'ProjectMember', 'User',
        function ($scope, $routeParams, ProjectMember, User) {
            $scope.members = ProjectMember.query({id_project: $routeParams.id_project});
            $scope.page_title = 'Listagem de membros de projeto';

            $scope.project_member = new ProjectMember();

            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project_member.$save({id_project: $routeParams.id_project}).then(function () {
                        $scope.project_member = new ProjectMember();
                        $scope.loadMember();
                        //$location.path('/projetos/' + $routeParams.id_project + '/membros');
                    });
                }
            }

            $scope.loadMember = function(){
                $scope.projectMembers = ProjectMember.query({
                    id_project: $routeParams.id_project,
                    orderBy: 'id',
                    sortedBy: 'desc',
                });
            }

            $scope.loadMember();

            $scope.formatName = function(model){
                if(model){
                    return model.name;
                }
                return '';
            }

            $scope.getUsers = function(name){
                return User.query({
                    search: name,
                    searchFields: 'name:like',
                }).$promise;
            }
            $scope.selectUser = function (item){
                $scope.project_member.user_id = item.id;
            }
            $scope.loadMember();

        }])


    .controller('ProjectMemberDeleteController',
    ['$scope', '$location', '$routeParams', 'ProjectMember',
        function ($scope, $location, $routeParams, ProjectMember) {
        $scope.project_member = new ProjectMember.get({
            id_project: $routeParams.id_project,
            id_member: $routeParams.id_member
        });

        $scope.page_title = 'Deletar membro';
        $scope.btn_text = 'Deletar';

        $scope.delete = function () {
            $scope.project_member.$delete({
                id_project: $scope.project_member.project_id,
                id_member: $scope.project_member.member_id,
            }).then(function () {
                $location.path('/projetos/' + $routeParams.id_project + '/membros');
            });
        }
    }])
