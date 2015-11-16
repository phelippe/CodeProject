angular.module('app.directives')
    .directive('projectFileDownload', ['$timeout', '$window', 'ProjectFile', 'appConfig', function ($timeout, $window, ProjectFile, appConfig) {
        return {
            restrict: 'E',
            templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
            link: function (scope, element, attr) {
                var anchor = element.children()[0];
                scope.$on('salvar-arquivo', function (event, data) {
                    $(anchor).removeClass('disabled');
                    $(anchor).text('Save File');
                    blobUtil.base64StringToBlob(data.file).then(function (blob) {
                        $(anchor).attr({
                            //href: 'data:application-octet-stream;base64,' + data.file,
                            href: $window.URL.createObjectURL(blob, data.mime_type),
                            download: data.name
                        });
                    });

                    $timeout(function () {
                        scope.downloadFile = function () {
                        };
                        $(anchor)[0].click();
                    });
                });
            },
            controller: ['$scope', '$element', '$attrs',
                function ($scope, $element, $attrs, $timeout) {
                    $scope.downloadFile = function () {
                        var anchor = $element.children()[0];
                        $(anchor).addClass('disabled');
                        $(anchor).text('Loading...');
                        ProjectFile.download(
                            {id_project: $attrs.idFile, id_file: $attrs.idFile}, function (data) {
                                $scope.$emit('salvar-arquivo', data);
                            });
                    };
                }],
        };
    }]);

//elemento <div project-file-download></div>
//<project-file-download></