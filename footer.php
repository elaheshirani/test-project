<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<script>
    var app = angular.module('myApp', []);
    app.controller('validateCtrl', function($scope) {
        $scope.name = 'John Doe';
        $scope.email = 'john.doe@gmail.com';
        $scope.password = '10000';
    });
</script>
</body>

</html>