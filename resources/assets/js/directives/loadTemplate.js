angular.module('app.directives')
    .directive('loadTemplate',
    ['$http', '$compile', 'OAuth', function ($http, $compile, OAuth) {
        return {
            restrict: 'E',
            link: function (scope, element, attr) {
                scope.$on('$routeChangeStart', function (event, nextRoute, current) {
                    if (OAuth.isAuthenticated()) {
                        if (nextRoute.$$route.originalPath != '/login' && nextRoute.$$route.originalPath != '/logout') {
                            if (!scope.isTemplateLoaded) {
                                scope.isTemplateLoaded = true;
                                $http.get(attr.url).then(function (response) {
                                    element.html(response.data);
                                    $compile(element.contents())(scope);
                                });
                            }
                            return;
                        }
                    }
                    resetTemplate();

                    function resetTemplate() {
                        scope.isTemplateLoaded = false;
                        element.html('');
                    }
                });
            },
        };
    }]);