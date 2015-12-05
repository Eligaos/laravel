(function() {
	'use strict';
	 document.getElementById("buttonCollapseSideBar").addEventListener("click", function () {
			var sideMenu = $('#sideMenu');
			var mainArea = $('#mainArea');
			if(sideMenu.hasClass("hiddenSidebar") === true){
				mainArea.toggleClass('col-md-7');
				mainArea.toggleClass('col-sm-7');
				sideMenu.toggleClass('hiddenSidebar');
				$('#buttonCollapseSideBar button img').attr( "src", "img/menuClose.png");
				sideMenu.toggle("slow");
			}else{
			 sideMenu.toggleClass( 'hiddenSidebar');
				$('#buttonCollapseSideBar button img').attr( "src", "img/menuOpen.png");
				sideMenu.toggle("slow");
				mainArea.toggleClass('col-md-7');
				mainArea.toggleClass('col-sm-7');
			}
		});
	/*
	 CHECK THIS:
	 https://jqueryui.com/tabs/#default */
	$(".nav-tabs a").click(function(){
		$(this).tab('show');
	});


	function gameLobbyController($scope,$log, ngDialog) {

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

		$scope.createGame = function(){
			if($scope.check($scope.linesSlider.value, $scope.linesSlider.value)){
				if(!($scope.playerValue <= ($scope.linesSlider.value*$scope.linesSlider.value/2))){
					$scope.msgErrorPlayers = "Insert correct number of players";
					if(!($scope.content != undefined)){
						$scope.msgErrorVis = "Select Game Visibility";
						console.log($scope.bot )
						if($scope.bot == true){
							console.log($scope.nrBots )
							console.log($scope.playerValue )
							if($scope.nrBots < $scope.playerValue){
							$scope.msgErrorBot = "Insert number of bots";
							}
						}
					}
				}
			}
		}

		$scope.resetErrors = function(){
			$scope.msgErrorPlayers = "";
			$scope.msgErrorVis = "";
			$scope.msgErrorBot = "";
		}

		$scope.createRoom = function () {
            ngDialog.open({
				template: 'createRoom.html',
				showClose: false,
				closeByEscape: false,
				data: $scope,
				closeByDocument: false,
				preCloseCallback: function (value)
                {
					if(value=="cancel"){
						$scope.linesSlider.value=2;
						$scope.columnSlider.value=2;
					}
                }
			});
		}

        $scope.check = function(lines, columns) {
            var tilesCount = lines*columns;
            if ((tilesCount)>80){
                $scope.msgErrorLines = "Game cannot have more than 80 tiles. Change Lines or Columns";
                return false;
            }

            if ((tilesCount)%2 != 0){
                $scope.msgErrorLines = "Game cannot have an odd number of tiles";
                $scope.msgErrorCols = "Game cannot have an odd number of tiles"
                return false;
            }
			$scope.msgErrorLines = "";
			$scope.msgErrorCols = ""
            return true;
        }

	}

		angular.module('lobby', ['ngDialog', 'rzModule']);
		angular.module('lobby').controller('gameLobbyController', ['$scope','$log', 'ngDialog', gameLobbyController]);

})();
