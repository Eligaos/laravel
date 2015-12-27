(function () {
    'use strict';
    document.getElementById("buttonCollapseSideBar").addEventListener("click", function () {
        var sideMenu = $('#sideMenu');
        var mainArea = $('#mainArea');
        if (sideMenu.hasClass("hiddenSidebar") === true) {
            mainArea.toggleClass('col-md-8');
            mainArea.toggleClass('col-sm-8');
            sideMenu.toggleClass('hiddenSidebar');
            $('#buttonCollapseSideBar button img').attr("src", "img/menuClose.png");
            sideMenu.toggle("slow");
        } else {
            sideMenu.toggleClass('hiddenSidebar');
            $('#buttonCollapseSideBar button img').attr("src", "img/menuOpen.png");
            sideMenu.toggle("slow");
            mainArea.toggleClass('col-md-8');
            mainArea.toggleClass('col-sm-8');
        }
    });
	
	
    /*
     CHECK THIS:
     https://jqueryui.com/tabs/#default */

    $('.nav-tabs a').click(function () {
        $(this).tab('show');
    });

    function chatController($scope, $log, $http ,modelsService) {
        var protocol = location.protocol;
        var port = '8080';
        var url = protocol + '//' + window.location.hostname + ':' + port;
        var socketChat = io.connect(url, {reconnect: true});

        $scope.chatMsg = "";
        $scope.chatMessages = [];
        $scope.sendMessage = function ($event, playerName) {
            if ($event.keyCode == 13) {
                console.log('msgChat to All ', playerName, $scope.chatMsg);
                socketChat.emit("chatInput", playerName, $scope.chatMsg);
                $scope.chatMsg = "";
            }
        };
        socketChat.on('chatOutput', function (name,msg) {
            console.log('newChatMsg', name, msg);
            if ($scope.chatMessages.length > 6)
                $scope.chatMessages.shift();
            $scope.chatMessages.push(name + ": " + msg);
            console.log($scope.chatMessages);
            $scope.$apply();
        });
    }

    function gameController($scope, $log, $http , $interval,  modelsService) {

        var protocol = location.protocol;
        var port = '8080';
        var url = protocol + '//' + window.location.hostname + ':' + port;
        var socket = io.connect(url, {reconnect: true});

    $scope.startGame = function () {

    }
    $scope.init = function (userID,gameID) {
        var params = {
            id: gameID
        };
        $http({
            method: 'GET',
            data: params,
            url: 'gameLobby/startGame/' + gameID
        }).then(function successCallback(response) {

            var game = response.data.game;
            $scope.game= modelsService.game(game.lines, game.columns);
            socket.emit("startGame",userID, gameID, game.lines, game.columns);

        }, function errorCallback(response) {
            //   console.log('There was an error on startGame request');
        });
    }
    socket.on('refreshGame', function(data){
        console.log(data);
        $scope.game = data;
        $scope.$apply();

    });

    $scope.image = function(tile){
        if(tile.getState() == "visible"){
            return tile.getID();
        }
        return tile.getState();
    }

    $scope.tileClick = function (user, gameID, tile) {
        if( $scope.game.playerTurn == user){
            socket.emit("playMove", user, gameID, tile);
        }
    }

    $scope.getImage = function (cols) {
        if (cols.state == "visible") {
            return "img/" + cols.id + ".png";
        }
        return "img/" + cols.state + ".png";
    }


}

    function gameLobbyController($scope, $log, $http , $interval, $parse, modelsService, ngDialog ) {
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

        $scope.joinGame = function (id) {
            var protocol = location.protocol;
            var port = '8080';
            var url = protocol + '//' + window.location.hostname + ':' + port;
            var socket = io.connect(url, {reconnect: true});
            //var url = 'gameLobby/joinGame';
            var params = {
                id: id
            };
            $http({
                method: 'POST',
                data: params,
                url: 'gameLobby/joinGame'
            }).then(function successCallback(response) {
                socket.emit("joinGame", id);
            }, function errorCallback(response) {
                //   console.log('There was an error on startGame request');
            });

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
    angular.module('lobby').controller('gameLobbyController', ['$scope', '$log','$http','$interval', '$parse', 'modelsService', 'ngDialog', gameLobbyController]);
    angular.module('lobby').controller('gameController', ['$scope', '$log','$http','$interval', 'modelsService', gameController]);
    angular.module('lobby').controller('chatController', ['$scope', '$log','$http', 'modelsService', chatController]);

})();
