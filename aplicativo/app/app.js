angular.module('app', ['ngRoute','ngAnimate', 'ngSanitize', 'ui.bootstrap']).
config(['$routeProvider', function($routeProvider) {
    $routeProvider.
    when('/', {templateUrl: 'app/common/listadoempleados.html', controller: ListCtrl}).
    otherwise({redirectTo: '/'});
}]);

angular.module('app').controller('ViewCtrl',['$uibModal', '$uibModalInstance','idEmpleado', '$http','$scope',
function ($uibModal, $uibModalInstance, idEmpleado, $http, $scope) {
	
	$http({ method: 'GET', url: 'api/empleado/'+idEmpleado
	}).then(function successCallback(response) {
		$scope.empleado = response.data;
		console.log($scope.empleado);
	});
	$scope.cancel = function () {
    	$uibModalInstance.dismiss('cancel');
  	};
}]);

function ListCtrl($scope, $http, $uibModal) {
	
  $scope.empleados = {};
  $scope.email = "";
  $http({ method: 'GET', url: 'api/'
  }).then(function successCallback(response) {
	$scope.empleados = response.data;
  });
  $scope.buscar = function(){
	  
	 var uri = $scope.email == "" ? 'api/' : 'api/buscar/'+$scope.email;
  	 $http({ method: 'GET', url: uri
	  }).then(function successCallback(response) {
		$scope.empleados = response.data;
	  });
  };
  
  $scope.showDetailEmplopyee = function (id) {
            
        var modalInstance = $uibModal.open({
            templateUrl: 'app/common/empleado.html',
            size: 'md',
            backdrop: 'static',
            keyboard: false,
            controller: 'ViewCtrl',
			resolve: {
                idEmpleado: function () {
                    return id;
                }
            }
        });
    };
}

