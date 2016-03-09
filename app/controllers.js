angular.module('tpro')

.controller('MainCtrl', function($scope, FileUploader, Files,$timeout,API_ENDPOINT){
    
    // Update $scope.files when a category is selected in the sidebar.
    // Being emitted from the Sidebar controller
    $scope.$on('filesFound', function(event, args){
        $scope.files = args.data;
    });
    
    // Update uploader's formData post vars with product so api can 
    // determine which folde  r to save installers into.
    // Also sets $scope.selectedItem. Used as a prefix for clipboard
    $scope.$on('selectedItem', function(event, args){
        var product = args;
        uploader.formData = [{product:product}];
        $scope.selectedItem = product;
    })
    
    // Instantiate File Uploader. FormData will be added throught $emit
    var uploader = $scope.uploader = new FileUploader({
        url: API_ENDPOINT.url + '/api/index.php/installers',
        method: 'POST'
    });
    
    uploader.onProgressItem = function(fileItem, response, status, headers){
        fileItem.progress = 50;
    }

    // On completion of Upload, clear the queue and show alert pop up
    uploader.onCompleteAll = function(fileItem, response, status, headers) {

        $timeout(function(){
             uploader.clearQueue();
        },2000);

        Files.getFiles($scope.selectedItem).then(function(response){
            $scope.$emit('filesFound',response);
        });

    };
    
    // Delete installers
    $scope.delete = function(container,blob){
        console.log(container+' '+blob);
        Files.deleteFile(container,blob);
        Files.getFiles($scope.selectedItem).then(function(response){
            $scope.$emit('filesFound',response);
        })
    }
    
})

.controller('NavbarCtrl', function($scope,$localStorage,$location,$http,Authentication){
   
    $scope.logout = function()
    {
        delete $localStorage.user;
        $location.path('/login');
        $http.delete('api/index.php/auth')
        .then(function(res){
            console.log(res)
        })
        .catch(function(err){
            console.log(err)
        });
    }
    
    $scope.showLogout = function(){
        if(Authentication.exists()){
            return true;
        }else{
            return false;
        }
    }
    
})

.controller('SidebarCtrl', function($scope,Files){
    
    $scope.getFiles = function(product){
        
        Files.getFiles(product).then(function(response){
            $scope.$emit('filesFound',response);
        });
        
        $scope.$emit('selectedItem', product);
        
        $scope.selectedItem = product;
        
    }
    
})

.controller('LoadingCtrl', function($scope, Application,$location){
    Application.registerListener(function(){$location.path('/');});
})

.controller('LoginCtrl', function($scope,Authentication,$location){
    
    $scope.submit = function(){
        
        var credentials = {
                email:$scope.username,
                password: $scope.password
            };
            
        Authentication.login(credentials).then(function(res){
            $location.path('/');
        }).catch(function(res){
            $location.path('/login');
        });
        
    }
    
})

.controller('DownloadCtrl', function($scope, Links,$timeout,$routeParams,$window){
    
    $scope.activeLink = false;
    $scope.checkingLink = true;
    $scope.progressBar = true;
    $scope.errorLink = false;
    
    $timeout(function(){
        Links.checkLink($routeParams.containerblobdate,$routeParams.hash).then(function(res){
            console.log(res);
            $scope.blobName = res.name;
            $scope.downloadLink = res.url;
            $scope.expiryDate = "Link will expire on "+res.date;
            $scope.activeLink = true;
            $scope.checkingLink = false;
            $scope.progressBar = false;
        }).catch(function(error){
            $scope.error = error.message ;
            $scope.errorLink = true;
            $scope.checkingLink = false;
        })
    },2000);
    
    $scope.startDownload = function(){
        
//        $window.location.href = $scope.downloadLink;
        
        Links.downloadLink($routeParams.containerblobdate,$routeParams.hash)
        .then(function(res){
             $scope.message = 'Please submit a ticket here if you are having issues downloading.';
            $scope.progressBar = false;
            $scope.blobName = "Download Complete";
        });
        

        }
    
    
    
})


