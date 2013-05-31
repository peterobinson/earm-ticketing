'use strict';

/* Controllers */

function LineItemsCtrl($scope, $http, pubsub) {
	var queryLineItems = function() {
		$http.get('tickets/apiv1/lineitems').success(function(items) {
			$scope.lineItems = items;
		});

		$http.get('tickets/apiv1/lineitems/create').success(function(blankItem) {
			$scope.blankLineItem = blankItem;	
		});
	}

	$scope.lineItem = {};
	$scope.masterItem = {};

	$scope.handleClick = function(item) {

        pubsub.publish('lineItemSelected', item);

        $scope.masterItem = item;
		$scope.lineItem = angular.copy(item);
    };

	var successSubmission = function(data) {
		if (data.error) {
			$scope.errors = data.messages;
			return false;
		}

		$scope.lineItem = data.lineItem;
		$scope.errors = ['Item updated successfully'];

		return true;
	}

	var errorAction = function(data) {
		$scope.errors = ['Connection error has occured'];
	}

    $scope.submitItem = function() {
    	if ($scope.lineItem.id == null) { //new item
			$http.post('tickets/apiv1/lineitems', $scope.lineItem)
				.success(function(data) {
					if (successSubmission(data)) {
						$scope.masteritem = angular.copy($scope.lineItem);
						$scope.lineItems.push($scope.masterItem);
						pubsub.publish('lineItemSelected', $scope.masterItem);
					}
				})
				.error(errorAction);
		}
		else {
			$http.put('tickets/apiv1/lineitems/' + $scope.lineItem.id, $scope.lineItem)
				.success(function(data) {
					if (successSubmission(data)) {
						for(var k in $scope.lineItem) {
							$scope.masterItem[k]=$scope.lineItem[k];
						}
					}
				})
				.error(errorAction);
		}
    }

    queryLineItems();
}

function TicketTypesCtrl($scope, $http, pubsub) {

	$scope.ticketType = null;
	$scope.master = null;

	var getTicketTypes = function(lineItem) {

		$http.get('tickets/apiv1/lineitems/' + lineItem.id + '/tickettypes').success(function(types) {
			$scope.ticketTypes = types;
		});

		$http.get('tickets/apiv1/tickettypes/create').success(function(type) {
			$scope.blankTicketType = type;
			$scope.blankTicketType.line_item_id = lineItem.id;
		});
	}

	pubsub.subscribe('lineItemSelected', function(passed) {

		if (passed.id == null) {
			$scope.ticketType = null;
			return;
		}
		getTicketTypes(passed);
	});

	

	$scope.ticketTypeSelect = function(type) {

		$scope.master = type;
		$scope.ticketType = angular.copy(type);
	}

	var successSubmission = function(data) {
		if (data.error) {
			$scope.errors = data.messages;
			return false;
		}

		$scope.ticketType = data.ticketType;
		$scope.errors = ['Item updated successfully'];

		return true;
	}

	var errorAction = function(data) {
		$scope.errors = ['Connection error has occured'];
	}

	$scope.submitType = function() {

		if ($scope.ticketType.id == null) { //new item
			$http.post('tickets/apiv1/tickettypes', $scope.ticketType)
				.success(function(data) {
					if (successSubmission(data)) {
						$scope.master = angular.copy($scope.ticketType);
						$scope.ticketTypes.push($scope.master);
					}
				})
				.error(errorAction);
		}
		else {
			$http.put('tickets/apiv1/tickettypes/' + $scope.ticketType.id, $scope.ticketType)
				.success(function(data) {
					if (successSubmission(data)) {
						for(var k in $scope.ticketType) {
							$scope.master[k]=$scope.ticketType[k];
						}
					}
				})
				.error(errorAction);
		}
	}
}

LineItemsCtrl.$inject = ['$scope', '$http', 'pubsub']; 

TicketTypesCtrl.$inject = ['$scope', '$http', 'pubsub'];


