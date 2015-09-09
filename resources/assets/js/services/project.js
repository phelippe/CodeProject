angular.module('app.services')
    .service('Project', ['$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/project/:id_project/', {id_project: '@id_project'}, {
            /*update: {
                method: 'PUT'
            }*/
        });
    }]);