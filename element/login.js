var app = angular.module('loginapp', []);
app.controller('loginctrl', function ($scope, $http, $sce) {
        $scope.submitloginForm = function(){
                $http.post('login.php?table=userlogin').then(function(res){
                        console.log(res);
                });
        };
});