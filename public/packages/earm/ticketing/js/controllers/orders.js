'use strict';

function OrderSearchCtrl($scope, $http, $timeout) {
	$scope.currentOrder = null;
	$scope.editOrder = null;

	$scope.loadOrder = function(order) {

		$scope.currentOrder = order;
		$scope.editOrder = null;
	}

	$scope.loadEditOrder = function() {
		$scope.editOrder = angular.copy($scope.currentOrder);
	}

	$scope.cancelEditOrder = function() {
		$scope.editOrder = null;
	}

	var successSubmission = function(data) {

		if (data.error) {
			$scope.errors = data.messages;
			return false;
		}

		$scope.editOrder = data.order;

		$scope.errors = ['Item updated successfully'];

		return true;
	};

	var errorAction = function(data) {
		$scope.errors = ['Connection error has occured'];
	};

	$scope.submitOrderDetails = function() {
		$http.put('tickets/apiv1/orders/' + $scope.editOrder.id, $scope.editOrder)
			.success(function(data) {
				if (successSubmission(data)) {
					for(var k in $scope.editOrder) {
						$scope.currentOrder[k]=$scope.editOrder[k];
					}
				}
			})
			.error(errorAction);
	}

	

	var queryOrders = function(searchString) {

		$http({
			url:'tickets/apiv1/orders',
			method: 'GET',
			params:{search:searchString}
		}).success(function(orders) {
			$scope.orderResults = orders;
		});
	};

	var searchTextTimeout;

    $scope.$watch('searchString', function (val) {
        if (searchTextTimeout) {
        	$timeout.cancel(searchTextTimeout);
        }

        searchTextTimeout = $timeout(function() {
            queryOrders(val);
        },600);
    });
}

OrderSearchCtrl.$inject = ['$scope', '$http', '$timeout'];
