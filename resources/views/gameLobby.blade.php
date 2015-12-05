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
 	  <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div id="navbar" class="navbar-collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">Top 10</a></li>
                 <li><a href="#">Profile</a></li>
               <li><a href="#">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      <div id="gamesList">
          <h1 class="page-header">Game Lobby</h1>
           <button class="btn btn-lg btn-primary btn-block" type="button" ng-click="createRoom()">Create Game</button>
          <div class="table-responsive">
            <table class="table table-striped ">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Size</th>
                  <th>Players</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Game 1</td>
                  <td>3 x 6</td>
                  <td>5 / 6</td>
                  <td><button class="btn btn-sm btn-primary btn-block" type="submit">Join</button>
                  <button class="btn btn-sm btn-info btn-block" type="submit">Details</button>
                  </td>
                </tr>
                <tr>
                  <td>Game 2</td>
                  <td>5 x 6</td>
  			      <td>1 / 2</td>
                  <td><button class="btn btn-sm btn-primary btn-block" type="submit">Join</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button>
                      </td>
                </tr>
                <tr>
                  <td>Game 3</td>
                  <td>2 x 6</td>
   				  <td>3 / 3</td>
                  <td><button class="btn btn-sm btn-primary btn-block" type="submit">View</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                <tr>
                  <td>Game 4</td>
                  <td>2 x 6</td>
     			  <td>3 / 4</td>
                  <td><button class="btn btn-sm btn-primary btn-block" type="submit">Join</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                <tr>
                  <td>Game 5</td>
                  <td>2 x 6</td>
     			  <td>4 / 4</td>
     			  <td><button class="btn btn-sm btn-warning btn-block" type="submit">Rejoin</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                  <tr>
                  <td>Game 5</td>
                  <td>2 x 6</td>
     			  <td>4 / 4</td>
     			  <td><button class="btn btn-sm btn-warning btn-block" type="submit">Rejoin</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                  <tr>
                  <td>Game 5</td>
                  <td>2 x 6</td>
     			  <td>4 / 4</td>
     			  <td><button class="btn btn-sm btn-warning btn-block" type="submit">Rejoin</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                       </tr>
                  <tr>
                  <td>Game 5</td>
                  <td>2 x 6</td>
     			  <td>4 / 4</td>
     			  <td><button class="btn btn-sm btn-warning btn-block" type="submit">Rejoin</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                       </tr>
                  <tr>
                  <td>Game 5</td>
                  <td>2 x 6</td>
     			  <td>4 / 4</td>
     			  <td><button class="btn btn-sm btn-warning btn-block" type="submit">Rejoin</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                       </tr>
                  <tr>
                  <td>Game 5</td>
                  <td>2 x 6</td>
     			  <td>4 / 4</td>
     			  <td><button class="btn btn-sm btn-warning btn-block" type="submit">Rejoin</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                       </tr>
                  <tr>
                  <td>Game 5</td>
                  <td>2 x 6</td>
     			  <td>4 / 4</td>
     			  <td><button class="btn btn-sm btn-warning btn-block" type="submit">Rejoin</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                       </tr>
                  <tr>
                  <td>Game 5</td>
                  <td>2 x 6</td>
     			  <td>4 / 4</td>
     			  <td><button class="btn btn-sm btn-warning btn-block" type="submit">Rejoin</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>
                       </tr>
                  <tr>
                  <td>Game 5</td>
                  <td>2 x 6</td>
     			  <td>4 / 4</td>
     			  <td><button class="btn btn-sm btn-warning btn-block" type="submit">Rejoin</button>
                      <button class="btn btn-sm btn-info btn-block" type="submit">Details</button></td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>

      </div>
    <div id="buttonCollapseSideBar" class="col-sm-1 col-md-1"><button class="btn btn-sm btn-primary" type="submit"><img src="img/menuClose.png"></button></div>
     <div id="mainArea" class="col-sm-7 col-md-7">
	     	<ul class="nav nav-tabs">
	    <li class="active"><a href="#home">Home</a></li>
	    <li><a href="#menu1">Menu 1</a></li>
	    <li><a href="#menu2">Menu 2</a></li>
	    <li><a href="#menu3">Menu 3</a></li>
	  </ul>
	  <div class="tab-content">
	    <div id="home" class="tab-pane fade in active">
	      <h3>HOME</h3>
	      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	    </div>
	    <div id="menu1" class="tab-pane fade">
	      <h3>Menu 1</h3>
	      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
	    </div>
	    <div id="menu2" class="tab-pane fade">
	      <h3>Menu 2</h3>
	      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
	    </div>
	    <div id="menu3" class="tab-pane fade">
	      <h3>Menu 3</h3>
	      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
	    </div>
	  </div>
</div>
     </div>
   </div>
      </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-2.1.4.js"></script>
    <script src="js/angular.js"></script>
    <script src="js/rzslider.js"></script>
    <script src="js/ngDialog.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/lobby.js"></script>
  </body>
</html>
