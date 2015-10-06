angular.module('app.services')
    .service('ProjectTask', ['$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/project/:id_project/tasks/:id_task', {
            id_project: '@id_project',
            id_note: '@id_task'
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