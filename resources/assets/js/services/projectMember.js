angular.module('app.services')
    .service('ProjectMember', ['$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/project/:id_project/members/:id_note', {
            id_project: '@id_project',
            id_note: '@id_member'
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