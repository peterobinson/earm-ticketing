<!DOCTYPE html>
<html lang="en" ng-app="ticketing">
<head>
	<meta charset="utf-8">
	<title>Backend</title>
	<link rel="stylesheet" href="<?=URL::asset("packages/earm/ticketing/css/smoothness/jquery-ui-1.10.3.custom.min.css")?>">
	<link rel="stylesheet" href="<?=URL::asset("packages/earm/ticketing/css/backend.css")?>">
	<script>

		var BASE_URL = 'http://localhost/ticketing/public/';
		var ASSET_URL = 'http://localhost/ticketing/public/packages/earm/ticketing/';

	</script>
	<script src="<?=URL::asset("packages/earm/ticketing/js/lib/dateFormat.js")?>"></script>
	<script src="<?=URL::asset("packages/earm/ticketing/js/lib/jquery-1.10.1.min.js")?>"></script>
	<script src="<?=URL::asset("packages/earm/ticketing/js/lib/jquery-ui-1.10.3.custom.min.js")?>"></script>
	<script src="<?=URL::asset("packages/earm/ticketing/js/angular.min.js")?>"></script>
	<script src="<?=URL::asset("packages/earm/ticketing/js/app.js")?>"></script>
	<script src="<?=URL::asset("packages/earm/ticketing/js/controllers.js")?>"></script>
	
</head>
<body>
	<div class="loader"></div>
	<div class="wrapper" ng-view></div>

</body>
</html>