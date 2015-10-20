angular.module('app.controllers')
    .controller('HomeController', ['$scope', '$cookies', '$timeout', '$pusher', 'Project', function ($scope, $cookies, $timeout, $pusher, Project) {

        /*Projects*/
        $scope.projects = [];
        $scope.projectsPerPage = 1000;

        $scope.projects = Project.query({
            limit: $scope.projectsPerPage,
            with: 'client',
        }, function (data) {
            $scope.projects = data.data;
        });
        //console.log($scope.projects);
        /*Projects #FIM# */

        /*TASKS*/
        $scope.tasks = [];
        var pusher = $pusher(window.client);
        var channel = pusher.subscribe('user.' + $cookies.getObject('user').id);
        channel.bind('CodeProject\\Events\\TaskWasIncluded',
            function (data) {
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