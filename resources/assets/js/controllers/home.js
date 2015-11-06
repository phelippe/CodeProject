angular.module('app.controllers')
    .controller('HomeController', ['$scope', '$cookies', '$timeout', '$pusher', 'Project', 'ProjectTask', function ($scope, $cookies, $timeout, $pusher, Project, ProjectTask) {

        /*Projects*/
        $scope.projects = [];
        $scope.projectsPerPage = 1000;

        Project.query({
            limit: $scope.projectsPerPage,
            with: 'client',
        }, function (data) {
            //console.log(data.data);
            $scope.projects = data.data;
        });
        //console.log($scope.projects);
        /*Projects #FIM# */

        /*TASKS*/
        $scope.tasks = [];
        ProjectTask.queryAll({
            limit: 6,
            //with: 'projects',
        }, function(data) {
            //console.log(data.data);
            $scope.tasks = data.data;
        });


        var pusher = $pusher(window.client);
        var channel = pusher.subscribe('user.' + $cookies.getObject('user').id);
        channel.bind('CodeProject\\Events\\TaskWasIncluded',
            function (data) {
                //console.log(data);
                if ($scope.tasks.length == 6) {
                    //remove o ultimo card para inserir um mais novo no topo da lista
                    $scope.tasks.splice($scope.tasks.length - 1, 1);
                }
                $timeout(function () {
                    $scope.tasks.unshift(data.task);
                }, 1000);
            });
        /*TASKS #FIM# */
    }]);