angular.module('app.directives')
    .directive('projectFileDownload', ['ProjectFile', 'appConfig', function(ProjectFile, appConfig){
        return {
            restrict: 'E',
            templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
            link: function(scope, element, attr){

            },
            controller: [ '$scope', '$attrs', function($scope, $attrs){

            }],
        };
    }]);

//elemento <div project-file-download></div>
//<project-file-download></