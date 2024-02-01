var app = angular.module('myapp', []);

app.controller('phpctrl', function ($scope, $http, $sce) {
    $scope.showdetails = false;
    $scope.showdetailsPages = false;
    $scope.formData = {};
    $scope.formdata = {};
    

    $http.get('script.php?table=jobs').then(function (res) {
        $scope.records = res.data;
    });

    $scope.btnclicked = function(){
        angular.forEach($scope.records, function(record) {
            $scope.trustedDescription = $sce.trustAsHtml(record.description);
        });
        $scope.showdetails = true;
    };

    $scope.getpages = function(){
        $http.get('script.php?table=pages').then(function (res) {
            console.log(res.data);
            $scope.recordsPages = res.data;
            $scope.showdetailsPages = true;
        });
    };


    

    $scope.submitForm = function () {
        console.log($scope.formData);
        $http.post('update.php', JSON.stringify($scope.formData), { headers: { 'Content-Type': 'application/json' } }).then(
            function (response) {
                console.log(response);
            },
            function (error) {
                console.error('Error updating data:', error);
            }
        );
    };
    
    $scope.formsdetails = function(){
        console.log($('#staticBackdrop'));
        $http.get('update.php').then(function (res) {
            console.log(res.data);
            $scope.frmsdetails = res.data;
        });
    };
    


});

app.controller('signupctrl', function ($scope, $http, $sce) {
    $scope.submitsigninForm = function(){
        $http.post('signup.php').then(function (res) {
            console.log(res);
        });
    };
});
