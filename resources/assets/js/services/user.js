angular.module('app.services')
    .service('User', ['$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/user', {}, {
            //isso é uma ação, similar a update, save, edit, delete, etc (referencia as ações do controller)
            authenticated: {
                url: appConfig.baseUrl + '/user/authenticated',
                method: 'GET',
            },
        });
    }]);