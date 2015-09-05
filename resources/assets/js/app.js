var app = angular.module('app', ['ngRoute', 'angular-oauth2', 'app.controllers']);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2', 'app.services']);
angular.module('app.services', ['ngResource']);

app.provider('appConfig', function () {
    var config = {
        baseUrl: 'http://localhost:8000',
    }

    return {
        config: config,
        $get: function () {
            return config;
        }
    };
});

app.config([
    '$routeProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider',
    function ($routeProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider) {
        $routeProvider
            .when('/login', {
                templateUrl: 'build/views/login.html',
                controller: 'LoginController',
            })
            .when('/home', {
                templateUrl: 'build/views/home.html',
                controller: 'HomeController',
            })
            .when('/clientes', {
                templateUrl: 'build/views/client/list.html',
                controller: 'ClientListController',
            })
            .when('/clientes/new', {
                templateUrl: 'build/views/client/new.html',
                controller: 'ClientNewController',
            })
            .when('/clientes/:id/edit', {
                templateUrl: 'build/views/client/edit.html',
                controller: 'ClientEditController',
            })
            .when('/clientes/:id/delete', {
                templateUrl: 'build/views/client/delete.html',
                controller: 'ClientDeleteController',
            });

        OAuthProvider.configure({
            baseUrl: appConfigProvider.config.baseUrl,
            clientId: 'appid1',
            clientSecret: 'secret',
            grantPath: 'oauth/access_token',
        });

        OAuthTokenProvider.configure({
            name: 'token',
            options: {
                secure: false,
            },
        });
    }]);

app.run(['$rootScope', '$window', 'OAuth', function ($rootScope, $window, OAuth) {
    $rootScope.$on('oauth:error', function (event, rejection) {
        // Ignore `invalid_grant` error - should be catched on `LoginController`.
        if ('invalid_grant' === rejection.data.error) {
            return;
        }

        // Refresh token when a `invalid_token` error occurs.
        if ('invalid_token' === rejection.data.error) {
            return OAuth.getRefreshToken();
        }

        // Redirect to `/login` with the `error_reason`.
        return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });
}]);