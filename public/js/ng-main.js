(function() {
	'use strict';

	var createBoard = function(lines, columns,model,game){
		var pieces = game.getBoard().arrayNumbers(lines*columns);
		for (var i = 0; i < pieces.length; i++) {
			game.getBoard().addTile(model.tile(pieces[i]));
		}
		return game.getBoard().getTiles();
	}

	var insertPieces = function(arrayPieces, lines, columns){
		var pieces = [[]];
		var counter = 0;
		for (var i = 0; i < lines; i++) {
			pieces[i] = [];
			for (var j = 0; j < columns; j++) {
				pieces[i][j] = arrayPieces[counter];

				counter++;
			}
		}
		return pieces;
	}

function gameController($scope, $interval, $http, modelsService, ngDialog) {


	////////////////HIGHSCORES////////////////////////////////////////////
	$scope.getTop = function() {
		$http({
			method: 'GET',
			url: 'highscores.php'
		}).then(function onSuccessCallback(response){
			$scope.top10 = response.data;     	 
		}, function onErrorCallback(response) {
		});
	};


	$scope.post  = function(operation, board_size, game_moves, elapsed_time, player_name) {
		$scope.getTop();
		var params = {
			op: operation,
			boardSize: board_size,
			moves: game_moves,
                elapsedTime: elapsed_time,//ms
                playerName: player_name
            };
            $http({
            	method: 'POST',
            	data: params,
            	url: 'highscores.php'
            }).then(function onSuccessCallback(response){
            	var result = response.data;
            	$scope.score =result['score'];
            	$scope.isTop = result['top'];	
            	if(operation == 'check'){
            		endGameDialog();
            	}else if(operation == 'update'){
            		$scope.top10 = response.data;
            	}
            }, function onErrorCallback(response) {
            });
        };
////////////////HIGHSCORES////////////////////////////////////////////


$scope.linesSlider = {
	value: 4,
	options: {
		floor: 2,
		ceil: 10,
		showTicks: true,
		disabled: false
	}
};
$scope.columnSlider = {
	value: 4,
	options: {
		floor: 2,
		ceil: 10,				
		showTicks: true,		
		disabled: false
	}
}

var endGameDialog = function () {
	ngDialog.open({
		template: 'externalTemplateDialog.html',
		showClose: false,
		closeByEscape: false,
		data: $scope,
		closeByDocument: false,
		preCloseCallback: function(value) {
			if($scope.isTop == true){
				if(value !== undefined) {
					$scope.post('update', $scope.game.board.columns*$scope.game.board.lines, $scope.moves, $scope.timer, value);
					$scope.getTop();
					return true;
				}
				return false;
			}
			return true;
		}
	});
}

$scope.tileClick = function(tile){
	if($scope.msgErrorLines == ""){
		if($scope.timer!=0 && $scope.start =="Start"){
			return false;
		}
		$scope.game.tileTouch(tile);
		$scope.moves= $scope.game.getMoves();
	}
}

$scope.start = "Start";
$scope.gameStart = function(lines, columns){
	if(check(lines, columns)){
		if($scope.start == "Start"){					
			$scope.start = "Stop";
			$scope.timer = 0;				
			$scope.remainingTiles = 0;	
			$scope.moves = 0;
			$scope.msgErrorLines = "";
			$scope.msgErrorCols = "";		
			enableSlider();
			$scope.game=modelsService.game(lines, columns);
			$scope.model=modelsService;
			$scope.tiles= insertPieces(createBoard(lines, columns,$scope.model, $scope.game),lines, columns);

			$scope.intervalPromiseTimer = $interval(function(){	
				$scope.timer++;
			},1000);
			$scope.intervalPromise = $interval(function(){	
				$scope.remainingTiles = $scope.game.getRemainingTiles();
				if($scope.game.endGame()){ 
					cancelInterval($scope.intervalPromise, $scope.intervalPromiseTimer);
					$scope.start = "Start";			
					disableSlider();
					$scope.top10  = $scope.post('check', lines*columns, $scope.moves, $scope.timer);
				}
			},1);}else{
				$scope.start = "Start";			
				disableSlider();
				cancelInterval($scope.intervalPromise, $scope.intervalPromiseTimer);				
			}
		}
	}

	var cancelInterval = function(intervalPromise, intervalPromiseTimer){
		$interval.cancel(intervalPromise);
		$interval.cancel(intervalPromiseTimer);
	}

	var enableSlider = function(){
		$scope.linesSlider.options.disabled = true;			
		$scope.columnSlider.options.disabled = true;
	}

	var disableSlider = function(){
		$scope.linesSlider.options.disabled = false;			
		$scope.columnSlider.options.disabled = false;
	}

	var check = function(lines, columns) {   
		var tilesCount = lines*columns;
		if ((tilesCount)>80){
			cancelInterval($scope.intervalPromise, $scope.intervalPromiseTimer);
			$scope.msgErrorLines = "Game cannot have more than 80 tiles. Change Lines or Columns";
			return false;
		}

		if ((tilesCount)%2 != 0){
			cancelInterval($scope.intervalPromise, $scope.intervalPromiseTimer);
			$scope.msgErrorLines = "Game cannot have an odd number of tiles";
			$scope.msgErrorCols = "Game cannot have an odd number of tiles"
			return false;
		}
		return true;
	}
}




angular.module('memoryGame', ['rzModule','ngDialog', 'modelsService', 'angular-flippy'])
angular.module('memoryGame').controller('gameController', ['$scope', '$interval', '$http','modelsService', 'ngDialog', gameController]);

angular.module('angular-flippy', [])
.directive('flippy', function() {
	return {
		restrict: 'EA',
		link: function($scope, $elem, $attrs) {
			var options = {
				flipDuration: ($attrs.flipDuration) ? $attrs.flipDuration : 400,
				timingFunction: 'ease-in-out',
			};
				// setting flip options
				angular.forEach(['flippy-front', 'flippy-back'], function(name) {
					var el = $elem.find(name);
					if (el.length == 1) {
						angular.forEach(['', '-ms-', '-webkit-'], function(prefix) {
							angular.element(el[0]).css(prefix + 'transition', 'all ' + options.flipDuration/1000 + 's ' + options.timingFunction);
						});
					}
				});
				//behaviour for flipping effect.
				 $scope.flip = function() {
				 	$elem.toggleClass('flipped');
				 }

				}
			};
		});


})();

