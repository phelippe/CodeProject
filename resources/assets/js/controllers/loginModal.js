angular.module('app.controllers')
    .controller('LoginModalController',
    ['$rootScope', '$scope', '$location', '$modalInstance',
        'authService', 'OAuth', '$cookies', 'User', 'OAuthToken',
        function ($rootScope, $scope, $location, $modalInstance,
                  authService, OAuth, $cookies, User, OAuthToken) {
            $scope.user = {
                username: '',
                password: '',
            };

            $scope.error = {
                message: '',
                error: false,
            };

            $scope.$on('event:auth-loginConfirmed', function () {
                $rootScope.loginModalOpened = false;
                $modalInstance.close();
            });

            $scope.$on('$routeChangeStart', function () {
                $rootScope.loginModalOpened = false;
                $modalInstance.close();
                //Ou esse de baixo;
                //$modalInstance.dismiss('cancel');
            });

            $scope.$on('event:auth-loginCancelled', function () {
                OAuthToken.removeToken();
            });

            $scope.login = function () {
                if ($scope.form.$valid) {
                    OAuth.getAccessToken($scope.user).then(function () {
                        User.authenticated({/*parametros*/}, {/*dados*/}, function (data) {
                            $cookies.putObject('user', data);
                            authService.loginConfirmed();
                        });

                    }, function (data) {
                        $scope.error.error = true;
                        $scope.error.message = data.data.error_description;
                    });
                }
            };

            $scope.cancel = function () {
                authService.loginCancelled();
                $location.path('login');
            };
        }]);