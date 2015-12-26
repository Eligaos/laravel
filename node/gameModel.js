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
            this.gameID = undefined;
            this.gamePlayers = [];
			this.playerTurn = undefined;
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
                if (this.board.getTileByIndex(tile.index).getState() == "hidden") {
					if (this.firstTile == undefined){
						this.firstTile = this.board.getTileByIndex(tile.index);
						this.firstTile.setState("visible");
                        console.log(this.firstTile);
						this.firstTile.flipped = this.board.getTileByIndex(tile.index).flip();
						this.secondTile = undefined;
						this.moves++;

					}else if(this.secondTile == undefined){
						this.secondTile = this.board.getTileByIndex(tile.index);
						this.secondTile.setState("visible");
						this.secondTile.flipped = this.board.getTileByIndex(tile.index).flip();
						this.moves++
						return this.compare();
					}/* else{
						this.hideTiles();	
						this.moves++	
						this.firstTile = this.board.getTileByIndex(tile.index);
						this.firstTile.setState("visible");
						this.firstTile.flipped = this.board.getTileByIndex(tile.index).flip();
						clearTimeout(this.timeout);
					}*/
				}
			}

			Game.prototype.compare = function(){
				if (this.firstTile.id == this.secondTile.id) {
					this.tilesMatch();
					return true;
				} else if (this.firstTile.id != this.secondTile.id) {
					var that = this;

					setTimeout(function(){
						that.hideTiles();
                        return false;
					}
					, 1000);
				}
			}

			Game.prototype.hideTiles = function() {
                console.log("mismatch1");
                this.firstTile.flipped = false;
				this.secondTile.flipped = false;
				this.firstTile.state = "hidden";
				this.secondTile.state = "hidden";
				this.firstTile = undefined;
				this.secondTile = undefined;
                console.log("mismatch2");
                var player = this.gamePlayers.shift();
                this.gamePlayers.push(player);
                this.playerTurn = this.gamePlayers[0];
                console.log(this.gamePlayers);
			}

			Game.prototype.tilesMatch= function () {
				this.firstTile.state = "empty";
				this.secondTile.state = "empty";
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
		
module.exports = {
			game: function(lines, columns){
				return new Game(lines, columns);
			},
    tile: function(id){
        return new Tile(id);
    },

    board: function(lines,columns){
        return new Board(lines,columns);
    }
}