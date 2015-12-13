<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form method="POST" action="gameLobby/createRoom">
    <label for="gameName">Game Name:</label>
    <input class="form-control" type="text" name="gameName" id="gameName" ng-model="ngDialogData.gameName" required>
    <div>
        <label>Total Lines: {{ngDialogData.linesSlider.value}}</label>
        <rzslider name="lines" id="lines" rz-slider-model="ngDialogData.linesSlider.value"
                  rz-slider-options="ngDialogData.linesSlider.options"
                  rz-slider-hide-limit-labels="false"></rzslider>
        <span class="error" id="msgError_Lines"> {{ngDialogData.msgErrorLines}}</span>
    </div>

    <div>
        <label>Total Columns: {{ngDialogData.columnSlider.value}} </label>
        <rzslider name="columns" rz-slider-model="ngDialogData.columnSlider.value"
                  rz-slider-options="ngDialogData.columnSlider.options" rz-slider-hide-limit-labels="true"></rzslider>
        <span class="error" id="msgError_Cols">{{ngDialogData.msgErrorCols}}</span>
    </div>

    <label for="nrPlayer">Nº Players:</label>
    <input class="form-control" type="number" name="nrPlayer" id="nrPlayer" ng-model="ngDialogData.nrPlayers" min="0"
           required>
    <span class="error" id="msgError_Players">{{ngDialogData.msgErrorPlayers}}</span>
    <br>
    <label>Game Visibility:</label>
    <br>

    <div ng-init="ngDialogData.content='public'">
        <input type="radio" id="private" name="private" ng-value="1" ng-model="ngDialogData.isPrivate"> Private
        <br>
        <div ng-show="ngDialogData.isPrivate == '1'">
            <label>Token: </label>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <input class="form-control" name="token" type="text" id="token" ng-model="ngDialogData.token" disabled>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Copy</button>
                        </span>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div>

        <input type="radio" id="public" name="public" ng-value="0" ng-model="ngDialogData.isPrivate" checked="checked"> Public
    </div>
    <span class="error" id="msgError_Visibility">{{ngDialogData.msgErrorVis}}</span>
    <br>

    <div>
        <input type="checkbox" id="bots" value="bots" ng-model="ngDialogData.bot">Play with Bots?
        <div ng-show="ngDialogData.bot">
            <label>Bots:</label>

            <input class="form-control" type="number" name="nrBots" id="nrBots" ng-model="ngDialogData.nrBots" min="0" ng-required="ngDialogData.bot == 'bots'">

        </div>
        <span class="error" id="msgError_Bot">{{ngDialogData.msgErrorBot}}</span>
    </div>
    <br>

    <div id="btnsCreateRoom">
        <button class="btn btn-sm btn-primary" type="button" ng-click="ngDialogData.createRoom()">Create</button>
        <button class="btn btn-sm btn-primary" type="button" ng-click="closeThisDialog('cancel')">Cancel</button>
    </div>
</form>
</body>
</html>
