<!DOCTYPE html>
<html lang="en" ng-app="ticketing">
<head>
	<meta charset="utf-8">
	<title>Backend</title>
	<script>

		var BASE_URL = 'http://localhost/ticketing/public/';
		var ASSET_URL = 'http://localhost/ticketing/public/packages/earm/ticketing/';

	</script>
	
	<script src="<?=URL::asset("packages/earm/ticketing/js/angular.min.js")?>"></script>
	<script src="<?=URL::asset("packages/earm/ticketing/js/app.js")?>"></script>
	<script src="<?=URL::asset("packages/earm/ticketing/js/controllers.js")?>"></script>
	
</head>
<body>

	<div ng-view></div>

</body>
</html>