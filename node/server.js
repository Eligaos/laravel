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

var games= [];

console.log('Server listening on port ' + port);

io.on('connection', function (socket) {

    socket.on('startGame',function(gameId, lines,columns){
        console.log('\n----------------------------------------------------\n');
        console.log('Client requested "startGame" - gameId = ' + gameId);

        socket.join(gameId);

        if(games[gameId] == undefined) {
            games[gameId] = gameMod.game(lines,columns);
        }

        io.in(gameId).emit('refreshGame', games[gameId]);
        //console.log('Games ', games);
    });

    socket.on('playMove',function(gameId, tile){
        console.log('\n----------------------------------------------------\n');
        console.log('Client requested "playMove" - gameId = ' + gameId + ' move= ', tile.index);

        games[gameId].tileTouch(tile);

        io.in(gameId).emit('refreshGame', games[gameId]);

    });

    socket.on('chatInput', function (msg,name) {
        console.log("cheguei");
        io.emit('chatOutput', msg,name);
    });
});









