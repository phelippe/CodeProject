angular.module('app.services')
    .service('ProjectMember', ['$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/project/:id_project/members/:id_member', {
            id_project: '@id_project',
            id_member: '@id_member'
        }, {
            update: {
                method: 'PUT',
            },
        });
    }]);