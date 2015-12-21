<!DOCTYPE html>
 	<html lang="pt" ng-app="memoryGame">
 	<head>
 		<meta charset="UTF-8">
 		<title>Memory Game</title>
 		<link rel="stylesheet" type="text/css" href="https://rawgit.com/rzajac/angularjs-slider/master/dist/rzslider.css">
 		<link rel="stylesheet" type="text/css" href="css/normalize.css">
 		<link rel="stylesheet" type="text/css" href="css/styles.css">	
 		<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/redmond/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ng-dialog/0.4.0/css/ngDialog.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ng-dialog/0.4.0/css/ngDialog-theme-default.min.css">
 		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ng-dialog/0.4.0/css/ngDialog-theme-default.min.css">

	</head>
	<body ng-controller="gameController">
	<h1>Project 3</h1>
 		<h2>Memory Game</h2>
 		<div id="contentor" >
 			<div class="header" id="gameForm">
 				<form action="#" method="get" id="id_form" >
 					<div>
 						<label for="idLines">Total Lines: @{{linesSlider.value}}</label>
 						<rzslider rz-slider-model="linesSlider.value"  rz-slider-options="linesSlider.options" rz-slider-hide-limit-labels="false"></rzslider>
 						<span class="error" id="msgError_Lines"> @{{msgErrorLines}}</span>
 					</div>
 					
 					<div>
 						<label for="idCols">Total Columns: @{{columnSlider.value}} </label>
 						<rzslider rz-slider-model="columnSlider.value"  rz-slider-options="columnSlider.options" rz-slider-hide-limit-labels="true"></rzslider>
 						<span class="error" id="msgError_Cols">@{{msgErrorCols}}</span>
 					</div>
 					<div>
 						<input type="button" id="idStartButton" name="startButton" value="@{{start}}" ng-click="gameStart(linesSlider.value, columnSlider.value)">
 					</div>
 				</form>
 			</div>		
 			<div class="header" id="gameScore">
 				<div><span>Time:</span><span id="timeLabel"> @{{timer}} sec</span></div>
 				<div><span>Moves:</span><span id="movesLabel"> @{{moves}}</span></div>
 				<div><span>Remaining Tiles:</span><span id="tilesLabel"> @{{remainingTiles}}</span></div>
 			</div>				
 			<div id="main" >
 				<table id="gameBoard">
 					<tbody >
 						<tr ng-repeat="line in game.tiles">
 							<td ng-repeat="cols in line">
 								<flippy
 								ng-if = "cols.getState() != 'empty'"
 								class="fancy"
 								ng-class="{flipped:cols.flipped}"
 								ng-click="tileClick(cols,this)"
 								flip-duration="500"
 								timing-function="ease-in-out">
 								<flippy-front>
 								<img ng-src="img/hidden.png"/>
 							</flippy-front>

 							<flippy-back>
 							<img ng-src="img/@{{cols.id}}.png"/>
 						</flippy-back>

 					</flippy>
 					<img ng-if= "cols.getState() == 'empty'" ng-src="img/empty.png"/>
 				</td>
 			</tr>
 			<tbody>
 			</table>
 			<div id="idStudents">David Barbosa (2110099), Rúben Nunes (2111226), Mickaël Gomes (2130693)</div>
 		</div>	
 	</div>	
 	<div id="highscores">
 		<table>
 			<tbody ng-init="getTop() > 0">
 				<tr>
 					<td><span>Posição</span></td>
 					<td><span>Nome</span></td>
 					<td><span>Pontuação</span></td>
 				</tr>

 				<tr ng-model="top10" ng-repeat="t in top10">
 					<td><span >@{{$index+1}}</span></td>
 					<td><span >@{{t['name']}}</span></td>
 					<td><span >@{{t['score']}}</span></td>
 				</tr>				
 				<tbody>
 				</table>
 			</div>
 			<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
 			<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
 			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js"></script>
 			<script src="https://rawgit.com/rzajac/angularjs-slider/master/dist/rzslider.js"></script>	
 			<script src="https://cdnjs.cloudflare.com/ajax/libs/ng-dialog/0.4.0/js/ngDialog.min.js"></script>
 			<script src="js/model.js"></script>
 			<script src="js/ng-main.js"></script>
 		</body>
 		</html>