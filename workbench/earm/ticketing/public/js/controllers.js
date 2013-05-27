'use strict';

/* Controllers */

function LineItemsCtrl($scope, $http) {
	$http.get('tickets/apiv1/lineitems').success(function(data) {
		$scope.lineItems = data;
	});

	$scope.item = {};
	$scope.formDisabled = false;
	$scope.creationErrors = [];

	$scope.createItem = function() {
		$scope.formDisabled = true;
		$http.post('tickets/apiv1/lineitems', $scope.item)
			.success(function(data) {
				if (data.error) {
					$scope.creationErrors = data.messages;
				}
				else {
					$scope.lineItems.push(data.lineItem);
					$scope.creationErrors = [];
					$scope.item = {};
				}

				$scope.formDisabled = false;
			}).error(function(data) {
				$scope.creationErrors = ['Connection error has occured'];
				$scope.formDisabled = false;
			});
		}
}

function ItemDetailCtrl($scope, $http, $routeParams) {
	//console.log("DetailControl");
	$http.get('tickets/apiv1/lineitems/' + $routeParams.itemId).success(function(data) {
		$scope.lineItem = data;
	});
}


