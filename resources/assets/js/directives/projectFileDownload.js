angular.module('app.directives')
    .directive('projectFileDownload', ['ProjectFile', 'appConfig', function (ProjectFile, appConfig) {
        return {
            restrict: 'E',
            templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
            link: function (scope, element, attr) {

            },
            controller: ['$scope', '$element', '$attrs',
                function ($scope, $element, $attrs) {
                    $scope.downloadFile = function () {
                        var anchor = $element.children()[0];
                        $(anchor).addClass('disabled');
                        $(anchor).text('Loading...');
                        console.log($attrs.idFile);
                        ProjectFile.download(
                            {id_project: $attrs.idFile, id_file: $attrs.idFile},
                            function (data) {
                                $(anchor).removeClass('disabled');
                                $(anchor).text('Save File');
                                $(anchor).attr({
                                    href: 'data:application-octet-stream;base64,'+data.file,
                                    download: data.name,
                                });
                            });
                    };
                }],
        };
    }]);

//elemento <div project-file-download></div>
//<project-file-download></