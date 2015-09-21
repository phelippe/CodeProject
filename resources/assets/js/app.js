var app = angular.module('app', [
    'ngRoute', 'angular-oauth2', 'app.controllers', 'app.services', 'app.filters', 'app.directives',
    'ui.bootstrap.typeahead', 'ui.bootstrap.datepicker', 'ui.bootstrap.tpls',
    'ngFileUpload',
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
        urls:{
            projectFile: '/project/{{id_project}}/file/{{id_file}}'
        },
        utils: {
            transformRequest: function(data){
                if(angular.isObject(data)){
                    return $httpParamSerializerProvider.$get()(data);
                }
                return data;
            },
            transformResponse: function (data, headers) {
                var headersGetter = headers();
                if(headersGetter['content-type'] == 'application/json' ||
                    headersGetter['content-type'] == 'text/json' ){
                    var dataJson = JSON.parse(data);
                    //Verifica se possui a propriedade 'data'
                    if(dataJson.hasOwnProperty('data')){
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
    '$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider',
    function ($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider) {

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

        $httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;
        $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

        $routeProvider
            .when('/login', {
                templateUrl: 'build/views/login.html',
                controller: 'LoginController',
            })
            .when('/home', {
                templateUrl: 'build/views/home.html',
                controller: 'HomeController',
            })

            //CLIENTES
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
            })
            .when('/clientes/:id', {
                templateUrl: 'build/views/client/show.html',
                controller: 'ClientShowController',
            })

            //PROJETOS
            .when('/projetos', {
                templateUrl: 'build/views/project/list.html',
                controller: 'ProjectListController',
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

            //Project Notes
            .when('/project/:id_project/notes', {
                templateUrl: 'build/views/project_notes/list.html',
                controller: 'ProjectNoteListController',
            })
            .when('/project/:id_project/notes/new', {
                templateUrl: 'build/views/project_notes/new.html',
                controller: 'ProjectNoteNewController',
            })
            .when('/project/:id_project/notes/:id_note', {
                templateUrl: 'build/views/project_notes/show.html',
                controller: 'ProjectNoteShowController',
            })
            .when('/project/:id_project/notes/:id_note/edit', {
                templateUrl: 'build/views/project_notes/edit.html',
                controller: 'ProjectNoteEditController',
            })
            .when('/project/:id_project/notes/:id_note/delete', {
                templateUrl: 'build/views/project_notes/delete.html',
                controller: 'ProjectNoteDeleteController',
            })

            //Project Files
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