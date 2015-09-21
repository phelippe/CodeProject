angular.module('app.services')
    .service('ProjectFile', ['$resource', 'appConfig', 'Url', function($resource, appConfig, Url){
        var url = appConfig.baseUrl + Url.getUrlResource(appConfig.urls.projectFile);
        return $resource(url, {
            id_project: '@id_project',
            id_file: '@id_file'
        }, {
            /*save: {
                method: 'POST',
            },
            get: {
                isArray: true,
            },*/
            query: {
                method: 'GET',
                isArray: true,
            },
            update: {
                method: 'PUT',
            },
        });
    }]);