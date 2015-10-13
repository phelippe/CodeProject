angular.module('app.directives')
    .directive('loginForm',
    ['appConfig', function (appConfig) {
        return {
            restrict: 'E',
            templateUrl: appConfig.baseUrl + '/build/views/templates/form-login.html',
            scope: false,
        };
    }]);

//elemento <div project-file-download></div>
//<project-file-download></