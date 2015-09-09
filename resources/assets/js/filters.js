//Outra forma de fazer o filtro
/*angular.module('app.filters').filter('formatDatetime', ['$filter', function ($filter) {
    return function (input) {
        return $filter('date')(input, 'dd/MM/yyyy');
    }
}]);*/


app
    .filter('formatDatetime', function () {

        return function (data) {
            return Date.parse(data);
        };
    });
