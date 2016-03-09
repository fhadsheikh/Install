angular.module('tpro')

.directive('tproNavbar', function(){
    return {
        templateUrl: 'app/partials/common/navbar.html'
    }
})

.directive('tproSidebar', function(){
    return {
        templateUrl: 'app/partials/common/sidebar.html'
    }
})