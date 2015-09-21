angular.module('app.services')
    .service('Url', ['$interpolate', function($interpolate){
        return {
            getUrlFromUrlSymbol: function (url, params) {
                //'/projetos/{{id_project}}/file/{{id_file}}'
                //id_project = 1, id_file = 2
                //projeto/1/file/2
                var urlMod = $interpolate(url)(params);
                return urlMod.replace(/\/\//g,'/')
                    .replace(/\/$/,'');
            },
            getUrlResource: function(url){
                //'/projetos/{{id_project}}/file/{{id_file}}'
                //'/projetos/:id_project/file/:id_file'
                return url.replace(new RegExp('{{','g'), ':')
                    .replace(new RegExp('}}', 'g'), '');
            }
        }
    }]);