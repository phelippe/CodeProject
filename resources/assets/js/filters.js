//Outra forma de fazer o filtro
angular.module('app.filters')
    .filter('dateBr', ['$filter', function ($filter) {
        return function (input) {
            return $filter('date')(Date.parse(input), 'dd/MM/yyyy');
        }
    }])
    .filter('dateBrCHora', ['$filter', function ($filter) {
        return function (input) {
            return $filter('date')(Date.parse(input), 'dd/MM/yyyy HH:mm');
        }
    }]);

/*app
 .filter('formatDatetime', function () {

 return function (data) {
 return Date.parse(data);
 };
 });*/
