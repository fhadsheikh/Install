angular.module('tpro', ['ngRoute','ngclipboard','ngStorage','angularFileUpload'])

.config(['$routeProvider', function($routeProvider){
    
    $routeProvider
    .when('/', {
        templateUrl: 'app/partials/home.html',
        controller: 'MainCtrl'
    })
    .when('/login', {
        templateUrl: 'app/partials/login.html',
        controller: 'LoginCtrl'
    })
    .when('/loading', {
        templateUrl: 'app/partials/login.html',
        controller: 'LoadingCtrl'
    })
    .when('/download/:containerblobdate/:hash', {
        templateUrl: 'app/partials/download.html',
        controller: 'DownloadCtrl'
    })
    
}])

.run(function(Authentication,Application,$rootScope,$location,RouteFilter){
    
    Authentication.checkSession().then(function(){
        Application.makeReady();
    });
    
    $rootScope.$on('$locationChangeStart', function(scope,next,current){
        
        if($location.path() === '/loading') return;
        
        if(!Application.isReady())
        {
            $location.path('/loading');
        }
        
        RouteFilter.run($location.path());
        
    })
    
})

.run(function(RouteFilter, Authentication){
    
    RouteFilter.register('/', ['/'], function(){
        return Authentication.isAllowed();
    }, '/login');
    
})





