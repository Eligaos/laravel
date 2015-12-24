var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

/*app.get('/', function(req, res){
 res.sendfile('index.html');
 });
 */


io.on('connection', function (socket) {
    socket.on('chatInput', function (msg,name) {
        io.emit('chatOutput', msg,name);
    });
});

io.on('chat', function (socket) {
    console.log('chat');
});

http.listen(3000, function () {
    console.log('listening on *:3000');
});




