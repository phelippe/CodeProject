angular.module('app.services')
    .service('ProjectFile', ['$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/project/:id_project/file/:id_file', {
            id_project: '@id_project',
            id_file: '@id_file'
        }, {
            /*save: {
                method: 'POST',
            },
            get: {
                isArray: true,
            },
            query: {
                method: 'GET',
                //isArray: true,
            },*/
            update: {
                method: 'PUT',
            },
        });
    }]);