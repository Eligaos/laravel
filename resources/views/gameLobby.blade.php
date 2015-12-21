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
                          <li><a href="#">Top 10</a></li>
                          <li><a href="#">Profile</a></li>
                          <li><a href="logout">Logout</a></li>
                      </ul>
                      </li>
                      </ul>
                  </div><!--/.nav-collapse -->
              </div><!--/.container-fluid -->
          </nav>
          <div id="gamesList"  ng-init="listGames()">
              <h1 class="page-header">Game Lobby</h1>
              <button class="btn btn-lg btn-primary" type="button" name ng-click="createDialog()">Create Game</button>
              <button class="btn btn-lg btn-primary" name=private value="private" ng-click="ngPrivate =! ngPrivate" type="button">Private Games</button>


              <div ng-show="ngPrivate">
                  <input class="form-control" type="text" name="joinP" id="joinP" required>
                  <button class="btn btn-default" type="button" ng-click="joinPrivateGame()">Join</button>
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
                      <tbody  ng-repeat="game in gamesWaiting">
                      <tr>
                          <td>@{{ game.gameName}}</td>
                          <td>@{{ game.lines}} x @{{ game.columns}}</td>
                          <td>@{{ game.joinedPlayers}} / @{{ game.maxPlayers}}</td>

                          <td><button class="btn btn-sm btn-primary btn-block" id="game@{{game.game_id}}" ng-click="joinGame(game.game_id)" type="button">Join</button></td>
                      </tr>

                      </tbody>
                  </table>

                  <h3>Games Waiting to Start</h3>
                  <table class="table table-striped " id="gamesStarting">
                      <thead>
                      <tr>
                          <th>Name</th>
                          <th>Size</th>
                          <th>Players</th>
                          <th>Options</th>
                      </tr>
                      </thead>
                      <tbody  ng-repeat="game in gamesStarting">
                      <tr>
                          <td>@{{ game.gameName}}</td>
                          <td>@{{ game.lines}} x @{{ game.columns}}</td>
                          <td>@{{ game.joinedPlayers}} / @{{ game.maxPlayers}}</td>
                          <td><button class="btn btn-sm btn-primary btn-block" ng-click="startGame()">Start</button></td>
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
                      <tbody  ng-repeat="game in gamesPlaying">
                      <tr>
                              <td>@{{ game.gameName}}</td>
                              <td>@{{ game.lines}} x @{{ game.columns}}</td>
                              <td>@{{ game.joinedPlayers}} / @{{ game.maxPlayers}}</td>
                              <td><button class="btn btn-sm btn-primary btn-block" href="gameLobby/viewGame/@{{ game.game_id}}" type="submit">View</button></td>
                      </tr>

                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    <div id="buttonCollapseSideBar" class="col-sm-1 col-md-1"><button class="btn btn-sm btn-primary" type="submit"><img src="img/menuClose.png"></button></div>
     <div id="mainArea" class="col-sm-7 col-md-7">
	     	<ul id="activeGames"class="nav nav-tabs">
                @foreach($games as $key => $game)
                    @if($key == 0 )
                    <li class='active'><a data-toggle='tab' href="#gameHolder{{$game->game_id}}">{{$game->gameName}}</a></li>
                    @else
                        <li><a data-toggle='tab' href="#gameHolder{{$game->game_id}}">{{$game->gameName}}</a></li>
                    @endif
                @endforeach
	  </ul>
	  <div id="games-holder" class="tab-content">
          @foreach($games as $key => $game)
                @if($key == 0 )
                  <div id="gameHolder{{$game->game_id}}" class="tab-pane fade in active" >
                      <h3>{{$game->gameName}}</h3>
                      <div>
                          <table ng-controller="gameController" ng-init="init({{$game->game_id}})">
                              <tbody>
                              <tr ng-repeat="line in game.tiles">
                                  <td ng-repeat="cols in line"><img ng-click="tileClick(cols)" ng-src="@{{getImage(cols)}}" alt="img"></td>
                              </tr>

                              </tbody>
                          </table>
                      </div>
                  </div>
                @else
                  <div id="gameHolder{{$game->game_id}}" class="tab-pane fade">
                      <h3>{{$game->gameName}}</h3>
                      <div><table ng-controller="gameController"  ng-init="init({{$game->game_id}})">
                              <tbody >
                              <tr ng-repeat="line in game.tiles">
                                  <td ng-repeat="cols in line"><img ng-click="tileClick(cols)" ng-src="@{{getImage(cols)}}" alt="img"></td>
                              </tr>
                              </tbody>
                          </table>
                      </div>
                @endif
          @endforeach
	  </div>
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
