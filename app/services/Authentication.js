'use strict';

angular.module('tpro')
  .factory('Authentication', function Authentication($q, $http, $localStorage,Application,$location) {


    return  {
        
        checkSession: function()
        {
            
            var deferred = $q.defer();
            
            if($localStorage.user != undefined){

                $http.get('api/index.php/auth?AuthID='+$localStorage.user.AuthID).success(function(AuthID)
                {
                    // Check if user is defined first
                    if(AuthID) {
                        deferred.resolve(AuthID);
                    }
                    else
                    {
                        deferred.reject('Not Found');
                    }

                }).error(function(error)
                {
                    deferred.reject(error);
                    console.log('still here');
                    Application.forceReady();
                });
                
            } else {
                deferred.reject('No Active Session');
                Application.forceReady();
            }
                           
            return deferred.promise;
           
        },
        
        exists: function()
        {
            if($localStorage.user != undefined)
            {
                return $localStorage.user.AuthID != null;
            }
            else
            {
                return false;
            }
            
        },

        login: function(credentials)
        {
            var deferred = $q.defer();

            $http.post('api/index.php/auth', credentials).success(function(user)
            {
                if(user)
                {

                    $localStorage.user = user;
                    deferred.resolve(user);
                }
                else
                {
                    deferred.reject('Given credentials are incorrect');
                    console.log('fail');
                }

            }).error(function(error)
            {
                deferred.reject(error);
                console.log('fail2');
            });

            return deferred.promise;
        },


        logout: function()
        {
            delete $localStorage.user;
            
        },

        isAllowed: function()
        {
            return this.exists() && $localStorage.user.CompanyId == 1;
        }
    }
  });