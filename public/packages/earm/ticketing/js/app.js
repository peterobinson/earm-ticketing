'use strict';

/* App Module */

// angular.module('ticketing', []).
//   config(['$routeProvider', function($routeProvider) {
//   $routeProvider.
//       when('/', {templateUrl: ASSET_URL + 'partials/lineitems.html',   controller: LineItemsCtrl}).
//       when('/lineitem/:itemId', {templateUrl: ASSET_URL + 'partials/item-detail.html'}).
//       otherwise({redirectTo: '/'});
// }]);
(function() {
	var mod = angular.module('ticketing', []);

	mod.config(['$routeProvider', function($routeProvider) {
	  $routeProvider.
	      when('/', {templateUrl: ASSET_URL + 'partials/setup.html'}).
	      otherwise({redirectTo: '/'});
	}])

	mod.factory('pubsub', function() {
		var cache = {};
		return {
			publish: function(topic, arg) {

				if (cache[topic] != undefined) {
					for (var i=0; i<cache[topic].length; i++) {
						cache[topic][i].call(null, arg || null);
					}
				}
			},
			subscribe: function(topic, callback) {
				if(!cache[topic]) {
					cache[topic] = [];
				}
				cache[topic].push(callback);
				return [topic, callback];
			},
			unsubscribe: function(handle) {
				var t = handle[0];
				cache[t] && d.each(cache[t], function(idx){
					if(this == handle[1]){
						cache[t].splice(idx, 1);
					}
				});
			}
		}
	});

	mod.directive('pencetodecimal', function() {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function(scope, element, attr, ngModel) {
            function fromUser(val) {
            	return Math.round((val || 0)*100);
				//return (text || '').toUpperCase();
			}

			function toUser(val) {
				return Math.round((val || 0)) / 100;
				//return (text || '').toLowerCase();
			}
			ngModel.$parsers.push(fromUser);
			ngModel.$formatters.push(toUser);
        }
    };
});

	return mod;


})();

// angular.module('ticketing', []).
//   config(['$routeProvider', function($routeProvider) {
//   $routeProvider.
//       when('/', {templateUrl: ASSET_URL + 'partials/setup.html'}).
//       otherwise({redirectTo: '/'});
// }]).factory('mySharedService', function($rootScope) {
// 	var sharedService = {};
    
//     sharedService.data = '';

//     sharedService.prepForBroadcast = function(data) {
//         this.data = data;
//         this.broadcastItem();
//     };

//     sharedService.broadcastItem = function() {
//         $rootScope.$broadcast('handleBroadcast');
//     };

//     return sharedService;
// });