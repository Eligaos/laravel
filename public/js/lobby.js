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
            value: 0,
            options: {
                floor: 2,
                ceil: 10,
                showTicks: true,
                disabled: false
            }
        };
        $scope.columnSlider = {
            value: 0,
            options: {
                floor: 2,
                ceil: 10,
                showTicks: true,
                disabled: false
            }
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
                    console.log("asd")
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
            return true;
        }

	}

		angular.module('lobby', ['ngDialog', 'rzModule']);
		angular.module('lobby').controller('gameLobbyController', ['$scope','$log', 'ngDialog', gameLobbyController]);

})();
