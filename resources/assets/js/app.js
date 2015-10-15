var app = angular.module('app', [
    'ngRoute', 'angular-oauth2', 'app.controllers', 'app.services', 'app.filters', 'app.directives',
    'ui.bootstrap.typeahead', 'ui.bootstrap.datepicker', 'ui.bootstrap.tpls', 'ui.bootstrap.modal',
    'ngFileUpload', 'http-auth-interceptor', 'angularUtils.directives.dirPagination',
    'ui.bootstrap.dropdown',
]);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2', 'app.services']);
angular.module('app.filters', []);
angular.module('app.directives', []);
angular.module('app.services', ['ngResource']);

app.provider('appConfig', ['$httpParamSerializerProvider', function ($httpParamSerializerProvider) {
    var config = {
        baseUrl: 'http://localhost:8000',
        project: {
            status: [
                {value: 1, label: 'Não iniciado'},
                {value: 2, label: 'Iniciado'},
                {value: 3, label: 'Concluido'},
            ]
        },
        projectTask: {
            status: [
                {value: 1, label: 'Incompleta'},
                {value: 2, label: 'Completa'},
            ]
        },
        urls: {
            projectFile: '/project/{{id_project}}/file/{{id_file}}'
        },
        utils: {
            transformRequest: function (data) {
                if (angular.isObject(data)) {
                    return $httpParamSerializerProvider.$get()(data);
                }
                return data;
            },
            transformResponse: function (data, headers) {
                var headersGetter = headers();
                if (headersGetter['content-type'] == 'application/json' ||
                    headersGetter['content-type'] == 'text/json') {
                    var dataJson = JSON.parse(data);
                    //Verifica se possui a propriedade 'data'
                    if (dataJson.hasOwnProperty('data') && Object.keys(dataJson).length == 1) {
                        dataJson = dataJson.data;
                    }
                    return dataJson;
                }
                return data;
            }
        }
    }

    return {
        config: config,
        $get: function () {
            return config;
        }
    };
}]);

app.config([
    '$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider',
    'appConfigProvider',
    function ($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider,
              appConfigProvider) {

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;
        $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

        //Removendo interceptors do angular-oauth e do http-auth-interceptor
        $httpProvider.interceptors.splice(0, 1);
        $httpProvider.interceptors.splice(0, 1);

        $httpProvider.interceptors.push('oauthFixInterceptor');

        $routeProvider
            .when('/login', {
                templateUrl: 'build/views/login.html',
                controller: 'LoginController',
            })
            .when('/logout', {
                resolve: {
                    logout: ['$location', 'OAuthToken', function ($location, OAuthToken) {
                        OAuthToken.removeToken();
                        $location.path('/login');
                    }],
                }
            })
            .when('/home', {
                templateUrl: 'build/views/home.html',
                controller: 'HomeController',
            })

            //CLIENTES
            .when('/clientes/dashboard', {
                templateUrl: 'build/views/client/dashboard.html',
                controller: 'ClientDashboardController',
                title: 'Clientes',
            })
            .when('/clientes', {
                templateUrl: 'build/views/client/list.html',
                controller: 'ClientListController',
                title: 'Clientes',
            })
            .when('/clientes/new', {
                templateUrl: 'build/views/client/new.html',
                controller: 'ClientNewController',
                title: 'Clientes',
            })
            .when('/clientes/:id/edit', {
                templateUrl: 'build/views/client/edit.html',
                controller: 'ClientEditController',
                title: 'Clientes',
            })
            .when('/clientes/:id/delete', {
                templateUrl: 'build/views/client/delete.html',
                controller: 'ClientDeleteController',
                title: 'Clientes',
            })
            //está dando problemas
            /*.when('/clientes/:id', {
             templateUrl: 'build/views/client/show.html',
             controller: 'ClientShowController',
             title: 'Clientes',
             })*/

            //PROJETOS
            .when('/projetos', {
                templateUrl: 'build/views/project/list.html',
                controller: 'ProjectListController',
            })
            .when('/projetos/dashboard', {
                templateUrl: 'build/views/project/dashboard.html',
                controller: 'ProjectDashboardController',
            })
            .when('/projetos/novo', {
                templateUrl: 'build/views/project/new.html',
                controller: 'ProjectNewController',
            })
            .when('/projetos/:id_project/editar', {
                templateUrl: 'build/views/project/edit.html',
                controller: 'ProjectEditController',
            })
            .when('/projetos/:id_project/deletar', {
                templateUrl: 'build/views/project/delete.html',
                controller: 'ProjectDeleteController',
            })
            .when('/projetos/:id_project', {
                templateUrl: 'build/views/project/show.html',
                controller: 'ProjectShowController',
            })

            //PROJECT NOTES
            .when('/projetos/:id_project/notas', {
                templateUrl: 'build/views/project_notes/list.html',
                controller: 'ProjectNoteListController',
            })
            .when('/projetos/:id_project/notas/new', {
                templateUrl: 'build/views/project_notes/new.html',
                controller: 'ProjectNoteNewController',
            })
            .when('/projetos/:id_project/notas/:id_note', {
                templateUrl: 'build/views/project_notes/show.html',
                controller: 'ProjectNoteShowController',
            })
            .when('/projetos/:id_project/notas/:id_note/edit', {
                templateUrl: 'build/views/project_notes/edit.html',
                controller: 'ProjectNoteEditController',
            })
            .when('/projetos/:id_project/notas/:id_note/delete', {
                templateUrl: 'build/views/project_notes/delete.html',
                controller: 'ProjectNoteDeleteController',
            })

            //PROJECT FILES
            .when('/projetos/:id_project/files', {
                templateUrl: 'build/views/project_file/list.html',
                controller: 'ProjectFileListController',
            })
            .when('/projetos/:id_project/files/new', {
                templateUrl: 'build/views/project_file/new.html',
                controller: 'ProjectFileNewController',
            })
            .when('/projetos/:id_project/files/:id_file', {
                templateUrl: 'build/views/project_file/show.html',
                controller: 'ProjectFileShowController',
            })
            .when('/projetos/:id_project/files/:id_file/edit', {
                templateUrl: 'build/views/project_file/edit.html',
                controller: 'ProjectFileEditController',
            })
            .when('/projetos/:id_project/files/:id_file/delete', {
                templateUrl: 'build/views/project_file/delete.html',
                controller: 'ProjectFileDeleteController',
            })

            //PROJECT TASKS
            .when('/projetos/:id_project/tarefas', {
                templateUrl: 'build/views/project_tasks/list.html',
                controller: 'ProjectTaskListController',
            })
            .when('/projetos/:id_project/tarefas/new', {
                templateUrl: 'build/views/project_tasks/new.html',
                controller: 'ProjectTaskNewController',
            })
            /*.when('/projetos/:id_project/tarefas/:id_task', {
             templateUrl: 'build/views/project_tasks/show.html',
             controller: 'ProjectTaskShowController',
             })*/
            .when('/projetos/:id_project/tarefas/:id_task/edit', {
                templateUrl: 'build/views/project_tasks/edit.html',
                controller: 'ProjectTaskEditController',
            })
            .when('/projetos/:id_project/tarefas/:id_task/delete', {
                templateUrl: 'build/views/project_tasks/delete.html',
                controller: 'ProjectTaskDeleteController',
            })

            //PROJECT MEMBERS
            .when('/projetos/:id_project/membros', {
                templateUrl: 'build/views/project_members/list.html',
                controller: 'ProjectMemberListController',
            })
            .when('/projetos/:id_project/membros/:id_member/delete', {
                templateUrl: 'build/views/project_members/delete.html',
                controller: 'ProjectMemberDeleteController',
            })

        ;

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

app.run(['$rootScope', '$location', '$http', '$modal', 'httpBuffer', 'OAuth', 'authService',
    function ($rootScope, $location, $http, $modal, httpBuffer, OAuth, authService) {

        $rootScope.$on('$routeChangeStart', function (event, nextRoute, currentRoute) {
            if (nextRoute.$$route.originalPath != '/login') {
                if (!OAuth.isAuthenticated()) {
                    $location.path('login');
                } else {
                    OAuth.getRefreshToken();
                }
            }
        });

        $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {

            $rootScope.page_title = current.$$route.title;
            //Pode ser pegando do title alí em cima ou do rootscope como abaixo
            //$rootScope.page_title = current.$$route.page_title;

        });

        $rootScope.$on('oauth:error', function (event, data) {
            // Ignore `invalid_grant` error - should be catched on `LoginController`.
            if ('invalid_grant' === data.rejection.data.error) {
                return;
            }

            // Refresh token when a `invalid_token` error occurs.
            if ('access_denied' === data.rejection.data.error) {
                httpBuffer.append(data.rejection.config, data.deferred);

                if (!$rootScope.loginModalOpened) {
                    var modalInstance = $modal.open({
                        templateUrl: 'build/views/templates/login-modal.html',
                        controller: 'LoginModalController',
                    });
                    $rootScope.loginModalOpened = true;
                }
                return;
            }

            // Redirect to `/login` with the `error_reason`.
            return $location.path('login');
        });
    }]);