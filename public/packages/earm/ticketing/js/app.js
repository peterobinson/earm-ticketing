'use strict';

/* App Module */

angular.module('ticketing', []).
  config(['$routeProvider', function($routeProvider) {
  $routeProvider.
      when('/', {templateUrl: ASSET_URL + 'partials/lineitems.html',   controller: LineItemsCtrl}).
      when('/lineitem/:itemId', {templateUrl: ASSET_URL + 'partials/item-detail.html', controller: ItemDetailCtrl}).
      otherwise({redirectTo: '/'});
}]);