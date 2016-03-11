'use strict'

angular.module('tpro')
    .factory('Links', function Links($q, $http,$window,$timeout){
        return {
            checkLink: function(containerblobdate,hash)
            {
                var deferred = $q.defer();
                
                $http.get('api/index.php/installers/checklink?containerblobdate='+containerblobdate+'&hash='+hash)
                .success(function(res){
                    deferred.resolve(res);
                })
                .error(function(err){
                    deferred.reject(err);
                });
                
                return deferred.promise;
            },
            
            downloadLink: function(containerblobdate,hash)
            {
                var deferred = $q.defer();
                
                var link = 'api/index.php/installers/download?containerblobdate='+containerblobdate+'&hash='+hash;
                
                $window.location = link;
             
            }
        }
})