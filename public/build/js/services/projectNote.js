angular.module('app.services')
    .service('ProjectNote', ['$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/project/:id_project/notes/:id_note', {
            id_project: '@id_project',
            id_note: '@id_note'
        }, {
            /*save: {
                method: 'POST',
            },

            query: {
                method: 'GET',
                //isArray: true,
            },*/
            get: {
                isArray: true,
            },
            update: {
                method: 'PUT',
            },
        });
    }]);