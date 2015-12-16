(function () {

    'use strict';
    document.getElementById("buttonCollapseSideBar").addEventListener("click", function () {
        var sideMenu = $('#sideMenu');
        var mainArea = $('#mainArea');
        if (sideMenu.hasClass("hiddenSidebar") === true) {
            mainArea.toggleClass('col-md-7');
            mainArea.toggleClass('col-sm-7');
            sideMenu.toggleClass('hiddenSidebar');
            $('#buttonCollapseSideBar button img').attr("src", "img/menuClose.png");
            sideMenu.toggle("slow");
        } else {
            sideMenu.toggleClass('hiddenSidebar');
            $('#buttonCollapseSideBar button img').attr("src", "img/menuOpen.png");
            sideMenu.toggle("slow");
            mainArea.toggleClass('col-md-7');
            mainArea.toggleClass('col-sm-7');
        }
    });
    /*
     CHECK THIS:
     https://jqueryui.com/tabs/#default */
    $('.nav-tabs a').click(function () {
        $(this).tab('show');
    });


    function gameLobbyController($scope, $log, $http , $interval, modelsService, ngDialog) {

        $scope.joinGame = function(id){

            //var url = 'gameLobby/joinGame';
            var params = {
                id: id
            };
            $http({
                method: 'POST',
                data: params,
                url: 'gameLobby/joinGame'
            }).then(function successCallback(response) {

              //  var name = ;
              //  console.log(this);
               //$(this).attr("disabled", false);
             //   $('#game'+id).attr("disabled", true);

          //if(response.data.game.joinedPlayers == response.data.game.maxPlayers ){
            /*  $('#activeGames .active').removeClass('active');
              $('#games-holder .active').removeClass('active');


              $('#activeGames').append("<li  class='active'><a data-toggle='tab'' href=\'gameHolder" + response.data.game.game_id +"\'>"+response.data.game.gameName+"</a></li>");

              $('#games-holder').append("<div id=\'gameHolder" + response.data.game.game_id+ "' class='tab-pane fade in active'><h3>" + response.data.game.gameName + "</h3><table id='gameBoard'> <tbody > <tr ng-repeat='line in tilesHolder"+response.data.game.game_id+"'> <td ng-repeat='cols in line'><img ng-click='tileClick(cols)' ng-src='img/@{{image(cols)}}.png'></td> </tr> <tbody></table><div></div></div>");
              $('.gameHolder'+response.data.game.game_id).tab('show');
              createGame(response.data.game);*/

           // }
            }, function errorCallback(response) {
             //   console.log('There was an error on startGame request');
            });


        }
        $scope.linesSlider = {
            value: 2,
            options: {
                floor: 2,
                ceil: 10,
                showTicks: true,
                disabled: false
            }
        };
        $scope.columnSlider = {
            value: 2,
            options: {
                floor: 2,
                ceil: 10,
                showTicks: true,
                disabled: false
            }
        }
        $scope.startGame = function (gameID) {
            var params = {
                id: gameID
            };
            $http({
                method: 'GET',
                data: params,
                url: 'gameLobby/startGame/'+gameID
            }).then(function successCallback(response) {

                var game = response.data.game;
                var gameHolder = "gameHolder" + game.game_id;
                var modelHolder = "modelHolder" + game.game_id;
                var tilesHolder = "tilesHolder" + game.game_id;

                $scope.gameHolder = modelsService.game(game.lines, game.columns);
                $scope.modelHolder = modelsService;
                $scope.tilesHolder = insertPieces(createBoard(game.lines, game.columns ,$scope.modelHolder, $scope.gameHolder),game.lines, game.columns);
                //console.log($scope.tilesHolder);
            }, function errorCallback(response) {
                //   console.log('There was an error on startGame request');
            });
        }

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

        $scope.tileClick = function(tile){
            console.log("touch");
                $scope.gameHolder.tileTouch(tile);
              //  $scope.moves= $scope.game.getMoves();

        }
        $scope.getImage = function(cols) {
            if(cols.state == "visible"){
                return "/img/"+cols.id+".png";
            }
           return "/img/"+cols.state+".png";
        }

        $scope.listGames = function() {
          $interval(function () {
                var url = 'gameLobby/listGames';
                $http.get(url).then(function successCallback(response) {
                    $scope.gamesWaiting = response.data.gamesWaiting;
                    $scope.gamesPlaying = response.data.gamesPlaying;
                    $scope.gamesStarting = response.data.gamesStarting;
                }, function errorCallback(response) {
                    console.log('There was an error on startGame request');
                });
           },3000);
        }



        $scope.createGame = function () {
            if ($scope.gameName == undefined) {
                $scope.msgErrorGameName = "Insert a name for the Game";
                return false;
            }else{
                $scope.msgErrorGameName = "";
            }
            if ($scope.check($scope.linesSlider.value, $scope.columnSlider.value)) {
                if (!($scope.nrPlayers <= ($scope.linesSlider.value * $scope.columnSlider.value / 2))) {
                    $scope.msgErrorPlayers = "Insert correct number of players";
                    return false;
                }else{
                    $scope.msgErrorPlayers = "";
                }
                if ($scope.bot == true) {
                    if ($scope.nrBots == undefined) {
                        $scope.msgErrorBot = "Insert number of bots";
                        return false;
                    }else{
                        $scope.msgErrorBot = "";
                    }if(!($scope.nrBots <= $scope.nrPlayers)){
                        $scope.msgErrorBot = "Number of bots should be less than Max Players";
                        return false;
                    }else{
                        $scope.msgErrorBot = "";
                    }
                }
                return true;
            }
        }

        $scope.createRoom = function() {
            if($scope.createGame()) {
                $('#formCreateRoom').submit();
                $scope.diag.close();            }
        }

        $scope.resetDialog = function () {
            $scope.gameName =undefined;
            $scope.msgErrorGameName = "";
            $scope.msgErrorLines = "";
            $scope.msgErrorCols = "";
            $scope.nrPlayers=undefined;
            $scope.msgErrorPlayers = "";
            $scope.bot= false;
            $scope.nrBots= undefined;
            $scope.msgErrorBot = "";
            $scope.linesSlider.value = 2;
            $scope.columnSlider.value = 2;
        }

        $scope.createDialog = function () {
            $scope.diag =  ngDialog.open({
                template: 'createRoom.blade.php',
                showClose: false,
                closeByEscape: false,
                data: $scope,
                closeByDocument: false,
                preCloseCallback: function (value) {
                    if (value == "cancel") {
                        $scope.resetDialog();
                    }
                }
            });
        }

        $scope.check = function (lines, columns) {
            var tilesCount = lines * columns;
            if ((tilesCount) > 80) {
                $scope.msgErrorLines = "Game cannot have more than 80 tiles. Change Lines or Columns";
                return false;
            }

            if ((tilesCount) % 2 != 0) {
                $scope.msgErrorLines = "Game cannot have an odd number of tiles";
                $scope.msgErrorCols = "Game cannot have an odd number of tiles"
                return false;
            }
            $scope.msgErrorLines = "";
            $scope.msgErrorCols = "";
            return true;
        }
    }
    angular.module('lobby', ['modelsService', 'ngDialog', 'rzModule']);
    angular.module('lobby').controller('gameLobbyController', ['$scope', '$log','$http','$interval', 'modelsService', 'ngDialog', gameLobbyController]);

})();
