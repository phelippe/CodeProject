angular.module('app.services')
    .service('Project', ['$resource', 'appConfig', '$filter', '$httpParamSerializer', function($resource, appConfig, $filter, $httpParamSerializer){

        function transformData(data){
            if(angular.isObject(data) || data.hasOwnProperty('due_date')){
                var o = angular.copy(data);
                o.due_date = $filter('date')(data.due_date, 'yyyy-MM-dd HH:mm:ss');

                return appConfig.utils.transformRequest(o);
            }
            return data;
        };

        return $resource(appConfig.baseUrl + '/project/:id_project/', {id_project: '@id_project'}, {
            save: {
                method: 'POST',
                transformRequest: transformData,
            },
            get: {
                method: 'GET',
                transformResponse: function(data, headers){
                    var o = appConfig.utils.transformResponse(data, headers);
                    if(angular.isObject(o) && o.hasOwnProperty('due_date')){
                        var arrayDate = o.due_date.split('-'),//yyyy-MM-dd
                            month = parseInt(arrayDate[1])-1;
                        //dei split na ultima parte pra remover as horas
                        o.due_date = new Date(arrayDate[0], month, arrayDate[2].split(' ', 1));
                    }
                    return o;
                }
            },
            query: {
                isArray: false,
            },
            update: {
                method: 'PUT',
                transformRequest: transformData,
            }
        });
    }]);