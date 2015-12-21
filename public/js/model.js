var model = (function() {
	'use strict';



	function modelsServiceFactory(){
		var insertPieces = function(board, lines, columns){
			var arrayPieces = board.arrayNumbers(lines*columns);
			for (var i = 0; i < arrayPieces.length; i++) {
				board.addTile(new Tile(arrayPieces[i], i) );
			}
			var pieces = [[]];
			var counter = 0;
			for (var i = 0; i < lines; i++) {
				pieces[i] = [];
				for (var j = 0; j < columns; j++) {
					pieces[i][j] = board.tiles[counter];

					counter++;
				}
			}	
			return pieces;
		}

		/*-------------------------PEÇA----------------------------------*/
		var Tile = function(id, index) {
			this.id = id;
			this.state = "hidden";
			this.flipped = false;
			this.index = index;

			Tile.prototype.flip = function(){
				 this.flipped= !this.flipped;
			}

			Tile.prototype.getID = function(){
				return this.id;
			}

			Tile.prototype.getState = function (){
				return this.state;
			}

			Tile.prototype.setState = function (state){
				return	this.state = state;
			}
		}

		/*-------------------------BOARD----------------------------------*/
		var Board = function(lines,columns){
			this.lines = lines;
			this.columns = columns;
			this.tiles = [];

		Board.prototype.addTile =function (tile){
			this.tiles.push(tile);
		}

		Board.prototype.getTiles= function (){
			return this.tiles;
		}

		Board.prototype.getTileByIndex = function  (i){
			return this.tiles[i];
		}
		Board.prototype.arrayNumbers = function (sizeArrays) {
			var arrFull = [];
			for (var i = 0; i < 41 ; i++) {
				arrFull.push(i);
			}
			this.shuffle(arrFull);
			var arr = arrFull.slice(0, sizeArrays/2)  ;
			var finalArr = arr.concat(arr);
			return this.shuffle(finalArr); 
		}

		Board.prototype.shuffle =function (array) {
			var currentIndex = array.length, temporaryValue, randomIndex;
    			// While there remain elements to shuffle...
    			while (0 !== currentIndex) {
		        // Pick a remaining element...
		        randomIndex = Math.floor(Math.random() * currentIndex);
		        currentIndex -= 1;
		        // And swap it with the current element.
		        temporaryValue = array[currentIndex];
		        array[currentIndex] = array[randomIndex];
		        array[randomIndex] = temporaryValue;
		    }
		    return array;
		}

	}

	
	/*-------------------------GAME----------------------------------*/

	var Game = function(lines,columns){
		    this.board = new Board(lines,columns);
			this.tiles = insertPieces(this.board, lines, columns);
			this.firstTile = undefined;
			this.secondTile = undefined;
			this.pieces;
			this.timeout;
			this.remainingTiles = lines*columns;
			this.moves = 0;

			Game.prototype.getBoard = function(){
				return this.board;
			}

			Game.prototype.tileTouch =function(tile){
				if (tile.getState() == "hidden") {  
					if (this.firstTile==undefined){
						this.firstTile = tile;
						this.firstTile.setState("visible");
						this.firstTile.flip();
						this.secondTile = undefined;
						this.moves++;
					}else if(this.secondTile == undefined){
						this.secondTile = tile;				
						this.secondTile.setState("visible");						
						this.secondTile.flip();
						this.moves++
						return this.compare();
					} else{
						this.hideTiles();	
						this.moves++	
						this.firstTile = tile;
						this.firstTile.setState("visible");	
						this.firstTile.flip();
						clearTimeout(this.timeout);
					}          
				}
			}

			Game.prototype.compare = function(){
				if (this.firstTile.getID() == this.secondTile.getID()) {
					this.tilesMatch();			
					return true;
				} else if (this.firstTile.getID() != this.secondTile.getID()) {
					var that = this;
					this.timeout =  setTimeout(function(){
						that.hideTiles()
					}
					, 2000);
					return false;
				}
				return false;
			}

			Game.prototype.hideTiles = function() {				
				this.firstTile.flip();
				this.secondTile.flip();				
				this.firstTile.setState("hidden");
				this.secondTile.setState("hidden");
				this.firstTile = undefined;
				this.secondTile = undefined;
			}
			Game.prototype.tilesMatch= function () {
				this.firstTile.setState("empty");
				this.secondTile.setState("empty");
				this.remainingTiles = this.remainingTiles -2;				
				this.firstTile = undefined;
				this.secondTile = undefined;
			}

			Game.prototype.getRemainingTiles = function(){
				return this.remainingTiles;
			}

			Game.prototype.getMoves = function(){
				return this.moves;
			}

			Game.prototype.endGame = function(){
				if(this.remainingTiles == 0){
					return true;
				}
				return false;
			}
		}

		return {
			game: function(lines, columns){
				return new Game(lines, columns);
			}
		}

	}

	angular.module('modelsService', []);
	angular.module('modelsService').factory('modelsService', modelsServiceFactory);
})();
