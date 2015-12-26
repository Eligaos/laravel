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
var gamePlayers = [[]];

console.log('Server listening on port ' + port);

io.on('connection', function (socket) {

    socket.on('startGame',function(userID, gameId, lines,columns){
        console.log('\n----------------------------------------------------\n');
        console.log('Client requested "startGame" - gameId = ' + gameId);

        socket.join(gameId);

        if(games[gameId] == undefined) {
            games[gameId] = gameMod.game(lines,columns);
            games[gameId].gameID = gameId;
            games[gameId].gamePlayers.push(userID);
            games[gameId].playerTurn = games[gameId].gamePlayers[0];
        }
        if(games[gameId].gamePlayers.indexOf(userID) == -1){
            games[gameId].gamePlayers.push(userID);
        }
        //games[gameId].playerTurn = games[gameId].gamePlayers[0];
        console.log(games[gameId].gamePlayers);
        io.in(gameId).emit('refreshGame', games[gameId]);

    });

    socket.on('playMove',function(gameId, tile){
        console.log('\n----------------------------------------------------\n');
        console.log('Client requested "playMove" - gameId = ' + gameId + ' move= ', tile.index);

        games[gameId].tileTouch(tile);

        io.in(gameId).emit('refreshGame', games[gameId]);
        setTimeout(function(){
                io.in(gameId).emit('refreshGame', games[gameId]);
            }
            , 1000);

    });

    socket.on('hideTiles',function(gameId){
        console.log('\n----------------------------------------------------\n');
        console.log('Client requested "hideTiles"');

        games[gameId].hideTiles(games[gameId].firstTile, games[gameId].secondTile);

        io.in(gameId).emit('refreshGame', games[gameId]);

    });


    socket.on('chatInput', function (msg,name) {
        console.log("cheguei");
        io.emit('chatOutput', msg,name);
    });
});






