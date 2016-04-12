<!DOCTYPE html>
<html ng-app="tpro">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Install ClockWork</title>
        
        <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid" ng-controller="NavbarCtrl">
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#/"><i class="fa fa-modx"></i>CWInstallers</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="https://clockworks.ca/updatechanges">Release Changes <span class="sr-only">(current)</span></a></li>
                  <li><a href="https://clockworks.ca/support/">Submit a ticket</a></li>
              </ul>
            </div>
          </div>
        </nav>
        </div>
        <div class="container-fluid">
            <div class="row" style="top:80px;position:relative">
                <div class="col-md-8 col-md-offset-2" style="text-align:center">
                    <div class="jumbotron" style="margin-top:100px;">
                    <h1>{{blobName}}</h1>
                        
                    <h2 ng-show="errorLink">{{error}}</h2>
                    <p ng-show="message">{{message}}</p>
                    <a href="download/installer" class="btn btn-lg btn-primary" ng-show="activeLink" role="button" style="margin-top:30px">Start Download</a>
                        
                    <p ng-show="checkingLink">Verifying Link</p>
                    <div style="margin-top:50px" class="progress" ng-show="progressBar">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                    </div>
                    <p>{{expiryDate}}</p>
                </div>
            </div>  
        </div>
        
        <!-- JQUERY -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- ANGULAR -->
        <script src="bower_components/angular/angular.min.js"></script>
        <!-- ANGULAR ROUTER -->
        <script src="bower_components/angular-route/angular-route.min.js"></script>
        <!-- BOOTSTRAP -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- CLIPBOARD PLUGIN -->
        <script src="https://cdn.rawgit.com/zenorocha/clipboard.js/master/dist/clipboard.min.js"></script>
        <script src="bower_components/ngclipboard-master/dist/ngclipboard.min.js"></script>
        <!-- NGSTORAGE -->
        <script src="bower_components/ngStorage/ngStorage.min.js"></script>
        <!-- FILE UPLOAD -->
        <script src="bower_components/angular-file-upload/dist/angular-file-upload.min.js"></script>
        <!-- FILE DOWNLOAD -->
        <script src="bower_components/downloadjs/download.js"></script>
        <!-- ANGULAR APPLICATION -->
        <script src="app/app.js"></script>
        <script src="app/controllers.js"></script>
        <script src="app/directives.js"></script>
        <script src="app/constants.js"></script>
        <script src="app/services/Authentication.js"></script>
        <script src="app/services/Application.js"></script>
        <script src="app/services/Routefilter.js"></script>
        <script src="app/services/Files.js"></script>
        <script src="app/services/Links.js"></script>
        
        <div style="position:fixed;bottom:0px;float:right;background-color:white;width:100%;text-align:right;padding:5px;color:lightgray">Version 1.2</div>
        
    </body>
</html>