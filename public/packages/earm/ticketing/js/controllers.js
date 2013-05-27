'use strict';

/* Controllers */

function LineItemsCtrl($scope, $http, pubsub) {
	$http.get('tickets/apiv1/lineitems').success(function(data) {
		$scope.lineItems = data;
	});

 	$scope.handleClick = function(data) {

        pubsub.publish('lineItemSelected', data);
    };

    pubsub.subscribe('lineItemChange', function() {
   		$http.get('tickets/apiv1/lineitems').success(function(data) {
			$scope.lineItems = data;
		});
	});
}

function LineItemDetailCtrl($scope, $http, pubsub) {

	$scope.updateFormVisible = false;
	$scope.createFormVisible = false;
	
	$scope.errors = [];

	pubsub.subscribe('lineItemSelected', function(passed) {

		// create new
		if (passed == -1) {
			$http.get('tickets/apiv1/lineitems/create').success(function(data) {
				$scope.item = data;
				$scope.updateFormVisible = false;
				$scope.createFormVisible = true;
				
			});
		}
		else {
	       	$http.get('tickets/apiv1/lineitems/' + passed).success(function(data) {
				$scope.item = data;
				$scope.createFormVisible = false;
				$scope.updateFormVisible = true;
				
			});
       	}
	});

	$scope.updateItem = function() {

		
		$http.put('tickets/apiv1/lineitems/' + $scope.item.id, $scope.item)
			.success(function(data) {
				if (data.error) {
					$scope.errors = data.messages;
				}
				else {
					$scope.item = data.lineItem;
					$scope.errors = ['Item updated successfully'];
				}

				pubsub.publish('lineItemChange', $scope.item.id);

			}).error(function(data) {
				$scope.errors = ['Connection error has occured'];

			});
	}

	$scope.createItem = function() {

		
		$http.post('tickets/apiv1/lineitems', $scope.item)
			.success(function(data) {
				if (data.error) {
					$scope.errors = data.messages;
				}
				else {
					$scope.item = data.lineItem;
					$scope.errors = ['Item updated successfully'];
				}

				pubsub.publish('lineItemChange', $scope.item.id);

			}).error(function(data) {
				$scope.errors = ['Connection error has occured'];

			});
	}
}

function LineItemTicketTypes($scope, $http, pubsub) {
	pubsub.subscribe('lineItemSelected', function(passed) {
		$http.get('tickets/apiv1/lineitems/' + passed + '/tickettypes/').success(function(types) {
			$scope.ticketTypes = types;
		});
	});

	$scope.ticketTypeSelect = function(id) {
		pubsub.publish('ticketTypeSelected', id);
	}
}

function TicketTypeEditCtrl($scope,$http, pubsub) {
	$scope.testcurrency = 535;
	pubsub.subscribe('ticketTypeSelected', function(id) {
		$http.get('tickets/apiv1/tickettypes/' + id).success(function(data) {
			$scope.ticketTypes = data;
		});
	});
}

LineItemsCtrl.$inject = ['$scope', '$http', 'pubsub']; 

LineItemDetailCtrl.$inject = ['$scope', '$http', 'pubsub'];

LineItemTicketTypes.$inject = ['$scope', '$http', 'pubsub'];

TicketTypeEditCtrl.$inject = ['$scope', '$http', 'pubsub'];


