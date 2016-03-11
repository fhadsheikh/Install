angular.module('tpro')

.factory('Files', function Files($q,$http){
    
    return{
        getFiles: function(product){
            
            var deferred = $q.defer();

            var data = {'product':product};

            // @todo Make URL dynamic
            var req = {
             method: 'GET',
             url: '/install/api/index.php/installers?product='+product,
             headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }

            $http(req)
            .then(function onSuccess(response){
                deferred.resolve(response);
            })
            .catch(function onError(err){
                deferred.reject(err);
            })

            return deferred.promise;
        }
    }
    
})