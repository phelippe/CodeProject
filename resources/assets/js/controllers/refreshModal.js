angular.module('app.controllers')
    .controller('RefreshModalController',
    ['$rootScope', '$scope', '$location', '$interval', '$modalInstance',
        'authService', 'OAuth', 'User', 'OAuthToken',
        function ($rootScope, $scope, $location, $interval, $modalInstance,
                  authService, OAuth, User, OAuthToken) {

            $scope.$on('event:auth-loginConfirmed', function () {
                $rootScope.loginModalOpened = false;
                $modalInstance.close();
            });

            $scope.$on('$routeChangeStart', function () {
                $rootScope.loginModalOpened = false;
                $modalInstance.close();
            });

            $scope.$on('event:auth-loginCancelled', function () {
                OAuthToken.removeToken();
            });

            $scope.cancel = function () {
                authService.loginCancelled();
                $location.path('login');
            };

            OAuth.getRefreshToken().then(function () {
                $interval(function(){
                    authService.loginConfirmed();
                }, 3000);
            }, function (data) {
                $scope.cancel();
            });

        }]);