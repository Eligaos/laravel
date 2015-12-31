<!DOCTYPE html>
<html lang="en" ng-app="lobby">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard Template for Bootstrap</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/lobby.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/rzslider.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/ngDialog.min.css">
    <link rel="stylesheet" type="text/css" href="css/ngDialog-theme-default.min.css">
</head>

<body ng-controller="gameLobbyController">
<div class="container-fluid">
    <div class="row">
        <div id="sideMenu" class="col-sm-4 col-md-4 sidebar">
            @if(Auth::user() != null)
                <h3>Hello, {{Auth::user()->nickname}}</h3>
            @endif
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div id="navbar" class="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="/">Home</a></li>
                            <li><a href="#top10" data-toggle="collapse" data-parent="#accordionid"> TOP 10 </a></li>
                            <li><a href="logout">Logout</a></li>
                        </ul>
                        </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
            <h3 class="page-header">Chat</h3>

            <div id="chatZone" ng-controller="chatController">
                <lable id="chatMessage"></lable>
                <form id="chatForm">
                    <input id="m" autocomplete="off" ng-model="chatMsg"
                           ng-keypress="sendMessage($event,'{{Auth::user()->nickname}}')">
                </form>
                <ul id="messages">
                    <li ng-repeat="m in chatMessages track by $index">@{{ m }}</li>
                </ul>
            </div>
            <hr>
            <h2 class="page-header">Game Lobby</h2>

            <div style="text-align: center; visibility: hidden;" id="error">
                <span class="alert alert-info"> @{{ error }}</span>
            </div>
            <div id="gamesList" ng-init="listGames()">
                <div class="textAlignCenter">
                    <button class="btn btn-lg btn-primary" type="button" name ng-click="createDialog()">Create Game
                    </button>
                    <button class="btn btn-lg btn-primary" name=private value="private"
                            ng-click="ngPrivate =! ngPrivate"
                            type="button">Private Games
                    </button>
                </div>
                <div ng-show="ngPrivate">

                    <input class="form-control" type="text" name="joinP" id="joinP" required>
                    <button class="btn btn-sm btn-primary btn-block" type="button" ng-click="joinGame(-1)">Join</button>
                    </tbody>
                </div>

                <h3>Waiting for Players</h3>

                <div class="table-responsive">
                    <table class="table table-striped " id="gamesWaiting">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Players</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody ng-repeat="game in gamesWaiting">
                        <tr>
                            <td>@{{ game.gameName}}</td>
                            <td>@{{ game.lines}} x @{{ game.columns}}</td>
                            <td>@{{ game.joinedPlayers}} / @{{ game.maxPlayers}}</td>

                            <td>
                                <button class="btn btn-sm btn-primary btn-block" id="game@{{game.game_id}}"
                                        ng-click="joinGame(game.game_id, '{{Auth::user()->nickname}}')" type="button">
                                    Join
                                </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                    <h3>Games Playing</h3>
                    <table class="table table-striped " id="gamesPlaying">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Players</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody ng-repeat="game in gamesPlaying">
                        <tr>
                            <td>@{{ game.gameName}}</td>
                            <td>@{{ game.lines}} x @{{ game.columns}}</td>
                            <td>@{{ game.joinedPlayers}} / @{{ game.maxPlayers}}</td>
                            <td>
                                <button class="btn btn-sm btn-primary btn-block"
                                        href="gameLobby/viewGame/@{{ game.game_id}}" type="submit">View
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="buttonCollapseSideBar">
            <button class="btn btn-sm btn-primary" type="submit"><img src="img/menuClose.png"></button>
        </div>
        <div id="mainArea" class="col-sm-8 col-md-8">
            <div id="top10" class="collapse" style="width: 50%;">
                <div class="accordion-inner">
                    <h3>Top10</h3>
                    <table class="table table-striped " id="top10">
                        <thead>
                        <tr>
                            <th>Players</th>
                            <th>Wins</th>
                        </tr>
                        </thead>
                        <tbody ng-repeat="top in top10">
                        <tr>
                            <td>@{{ top.Player}}</td>
                            <td>@{{ top.Wins}} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <ul id="activeGames" class="nav nav-tabs">
                @foreach($games as $key => $game)
                    @if($key == 0 )
                        <li id="game{{$game->game_id}}" class='active'><a data-toggle='tab'
                                                                          href="#gameHolder{{$game->game_id}}">{{$game->gameName}}</a>
                        </li>
                    @else
                        <li id="game{{$game->game_id}}"><a data-toggle='tab'
                                                           href="#gameHolder{{$game->game_id}}">{{$game->gameName}}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div id="games-holder" class="tab-content">
                @foreach($games as $key => $game)
                    @if($key == 0 )
                        <div id="gameHolder{{$game->game_id}}" class="tab-pane fade in active">
                            <div ng-controller="gameController">
                                <div class="container-fluid">
                                    <div class="row">
                                        <h3>Game: {{$game->gameName}}</h3>
                                        <hr>
                                        <div class="col-sm-4 col-md-4">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Player</th>
                                                    <th>Pairs</th>
                                                    <th>Moves</th>
                                                    <th>Time</th>
                                                </tr>
                                                </thead>
                                                <tbody ng-repeat="player in game.gamePlayers">
                                                <tr>
                                                    <td id="playerNick">@{{ player.nickname }}</td>
                                                    <td>@{{ player.pairs }}</td>
                                                    <td>@{{ player.moves }}</td>
                                                    <td>@{{ player.time }}</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <table class="table table-striped">
                                                <caption>Game General Info</caption>
                                                <thead>
                                                <tr>
                                                    <th>Total Moves</th>
                                                    <th>Total Pairs</th>
                                                    <th>Remaining Pairs</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>@{{game.moves }}</td>
                                                    <td>@{{game.board.lines*game.board.columns/2 - game.remainingTiles/2 }}</td>
                                                    <td>@{{game.remainingTiles /2}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-sm-7 col-md-7">
                                            <table class="marginAuto"
                                                   ng-init="init('{{Auth::user()->nickname}}', {{$game->game_id}})">
                                                <tbody>
                                                <tr ng-repeat="line in game.tiles">
                                                    <td ng-repeat="cols in line">
                                                        @{{cols.id}}
                                                        @{{cols.flipped}}
                                                        <flippy
                                                                ng-if="cols.state != 'empty'"
                                                                class="fancy"
                                                                ng-class="{flipped:cols.flipped}"
                                                                ng-click="tileClick('{{Auth::user()->nickname}}', {{$game->game_id}}, cols)"
                                                                flip-duration="500"
                                                                timing-function="ease-in-out">
                                                            <flippy-front>
                                                                <img ng-src="img/hidden.png"/>
                                                            </flippy-front>

                                                            <flippy-back>
                                                                <img ng-src="img/@{{cols.id}}.png"/>
                                                            </flippy-back>

                                                        </flippy>
                                                        <img ng-if="cols.state == 'empty'" ng-src="img/empty.png"/>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="gameHolder{{$game->game_id}}" class="tab-pane fade">
                            <div ng-controller="gameController">
                                <div class="container-fluid">
                                    <div class="row">
                                        <h3>Game: {{$game->gameName}}</h3>
                                        <hr>
                                        <div class="col-sm-4 col-md-4">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Player</th>
                                                    <th>Pairs</th>
                                                    <th>Moves</th>
                                                    <th>Time</th>
                                                </tr>
                                                </thead>
                                                <tbody ng-repeat="player in game.gamePlayers">
                                                <tr>
                                                    <td>@{{ player.nickname }}</td>
                                                    <td>@{{ player.pairs }}</td>
                                                    <td>@{{ player.moves }}</td>
                                                    <td>@{{ player.time }}</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <table class="table table-striped">
                                                <caption>Game General Info</caption>
                                                <thead>
                                                <tr>
                                                    <th>Total Moves</th>
                                                    <th>Total Pairs</th>
                                                    <th>Remaining Pairs</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>@{{game.moves }}</td>
                                                    <td>@{{game.board.lines*game.board.columns/2 - game.remainingTiles/2 }}</td>
                                                    <td>@{{game.remainingTiles /2}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-sm-7 col-md-7">
                                            <table class="marginAuto"
                                                   ng-init="init('{{Auth::user()->nickname}}', {{$game->game_id}})">
                                                <tbody>
                                                <tr ng-repeat="line in game.tiles">
                                                    <td ng-repeat="cols in line">
                                                        @{{cols.flipped}}
                                                        @{{cols.id}}
                                                        <flippy
                                                                ng-if="cols.state != 'empty'"
                                                                class="fancy"
                                                                ng-class="{flipped:cols.flipped}"
                                                                ng-click="tileClick('{{Auth::user()->nickname}}', {{$game->game_id}}, cols)"
                                                                flip-duration="500"
                                                                timing-function="ease-in-out">
                                                            <flippy-front>
                                                                <img ng-src="img/hidden.png"/>
                                                            </flippy-front>

                                                            <flippy-back>
                                                                <img ng-src="img/@{{cols.id}}.png"/>
                                                            </flippy-back>

                                                        </flippy>
                                                        <img ng-if="cols.state == 'empty'" ng-src="img/empty.png"/>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>


<form method="POST" id="formCreateRoom" action="gameLobby/createRoom">
    <input type="hidden" name="_token" value="{!!  csrf_token()!!}">
    <input type="hidden" name="gameName" value="@{{gameName}}">
    <input type="hidden" name="lines" value="@{{linesSlider.value}}">
    <input type="hidden" name="columns" value="@{{columnSlider.value}}">
    <input type="hidden" name="nrPlayers" value="@{{nrPlayers}}">
    <input type="hidden" name="isPrivate" value="@{{isPrivate}}">
    <input type="hidden" name="token" value="@{{token}}">
    <input type="hidden" name="nrBots" value="@{{nrBots}}">
</form>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/clipboard.js"></script>
<script src="js/socket.io-1.3.7.js"></script>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/angular.js"></script>
<script src="js/rzslider.js"></script>
<script src="js/ngDialog.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/model.js"></script>
<script src="js/ng-main.js"></script>
<script src="js/lobby.js"></script>
</body>
</html>
