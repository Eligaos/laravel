var app = require('express')();
var http =  require('http');
var io = require('socket.io')(http);
var gameMod = require('./gameModel');
var port = 8080;


//start http
var server = http.createServer(function(req, res){
});
var io = io.listen(server, {
    log: false,
    agent: false,
    origins: '*:*'
    // 'transports': ['websocket', 'htmlfile', 'xhr-polling', 'jsonp-polling']
});


server.listen(port);

var games = [];

console.log('Server listening on port ' + port);


function checkPlayerInGame(gameId, userID){
    for (var i = 0, len =  games[gameId].gamePlayers.length; i < len; i++) {
        if( games[gameId].gamePlayers[i]["nickname"] == userID){
            return i;
        }
    }
    return -1;
}


io.on('connection', function (socket) {

    socket.on('startGame',function(userID, gameId, lines,columns){
        console.log('\n----------------------------------------------------\n');
        console.log('Client requested "startGame" - gameId = ' + gameId);

        socket.join(gameId);

        if(games[gameId] == undefined) {
            games[gameId] = gameMod.game(lines,columns);
            games[gameId].gameID = gameId;
            var player = {nickname: userID, moves: 0, pairs: 0, time: 0};
            games[gameId].gamePlayers.push(player);
            games[gameId].playerTurn = games[gameId].gamePlayers[0]["nickname"];
        }
        if(checkPlayerInGame(gameId, userID) == -1){
            var player = {nickname: userID, moves: 0, pairs: 0, time: 0};
            games[gameId].gamePlayers.push(player);
        }
        console.log(games[gameId].gamePlayers);
        io.in(gameId).emit('refreshGame', games[gameId]);

    });

    socket.on('playMove',function(user, gameId, tile){
        console.log('\n----------------------------------------------------\n');
        console.log('Client requested "playMove" - gameId = ' + gameId + ' move= ', tile.index);

       var playerPosition =  checkPlayerInGame(gameId, user);
        console.log(playerPosition);
        games[gameId].tileTouch(tile, playerPosition);

        io.in(gameId).emit('refreshGame', games[gameId]);
        setTimeout(function(){
                io.in(gameId).emit('refreshGame', games[gameId]);
            }
            , 1000);

    });

    socket.on('joinGame',function(gameId){
        console.log('\n----------------------------------------------------\n');
        console.log('Client requested "joinGame" - gameId = ' + gameId);

        socket.join(gameId);

        io.in(gameId).emit('refreshGame', games[gameId]);
    });

    socket.on('showGame',function(gameId){
        console.log('\n---------------ShowGame------------------------\n');
        io.in(gameId).emit('refreshGame', games[gameId]);
    });

    socket.on('chatInput', function (msg,name) {
        io.emit('chatOutput', msg,name);
    });
});






