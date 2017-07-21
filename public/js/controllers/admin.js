angular.module('adminApp', [])
    .controller('mainCtrl', ['$scope', '$http', function ($scope, $http) {
        $scope.loader = false;

        $http.get('/admin/all')
            .then(function (data) {
                $scope.admins = data.data;
            }, function (error) {
                console.log(error)
            });

        $http.get('/organisation/all')
            .then(function (data) {
                $scope.orgs = data.data;
            }, function (error) {
                console.log(error)
            });

        $http.get('/sub-contractor/all')
            .then(function (data) {
                $scope.subs = data.data;
            }, function (error) {
                console.log(error)
            });
        $scope.organisation = '';
        $scope.add = function () {
            $scope.loader = true;

            var organisation_id = $('#organisation_id').val();
            var sub_contractor_id = $('#sub_contractor').val();

            var post = {
                name: $scope.name,
                email: $scope.email,
                role: $scope.role,
                organisation_id: organisation_id,
                sub_contractor_id: sub_contractor_id
            };
            console.log(post);
            $http.post('/admin/add', post)
                .then(function (data) {
                    swal(data.data);
                    $scope.loader = false;
                    $('#myModal').modal('toggle');
                    $('#addCraneForm').trigger('reset');
                    $http.get('/admin/all')
                        .then(function (data) {
                            $scope.admins = data.data;
                        }, function (error) {
                            console.log(error)
                        });
                }, function (error) {
                    $scope.loader = false;
                    swal('', Object.values(error.data)[0], 'error');
                })

        };
        $scope.open = function (admin) {
            console.log(admin)
        };
        $scope.edit = function (admin) {
            $('#editModal').modal('show');
            $scope.adminE = admin;

            $scope.updateCrane = function () {
                $scope.loader = true;

                var post = {
                    id: $scope.adminE.id,
                    name: $scope.adminE.name,
                    model: $scope.adminE.model,
                    driver_id: $scope.adminE.driver.id,
                    defect: $scope.adminE.defect
                };

                $http.post('/admin/update', post)
                    .then(function (data) {
                        swal(data.data);
                        $scope.loader = false;
                        $http.get('/admin/all')
                            .then(function (data) {
                                $scope.admins = data.data;
                            }, function (error) {
                                console.log(error)
                            });


                    }, function (error) {
                        swal('', Object.values(error.data)[0], 'error');
                        $scope.loader = false;
                    })
            }

        };
        $scope.delete = function (admin) {
            swal({
                    title: "DELETE USER",
                    text: "Name - " + admin.name,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    confirmButtonColor: "#dd140f",
                    confirmButtonText: "Yes, delete!",
                    showLoaderOnConfirm: true,
                },
                function () {
                    var post = {
                        id: admin.id
                    };
                    $http.post('/admin/delete', post)
                        .then(function (data) {
                            swal('', data.data, 'success');
                            $http.get('/admin/all')
                                .then(function (data) {
                                    $scope.admins = data.data
                                }, function (error) {
                                    console.log(error)
                                });
                        }, function (error) {
                            console.log(error)
                        });
                });
            console.log(admin)
        };
        $scope.closeEdit = function () {
            $('#editCraneForm').trigger('reset');
            $scope.adminE = [];
            $http.get('/api/admin/get')
                .then(function (data) {
                    $scope.admins = data.data;
                }, function (error) {
                    console.log(error)
                });
        }
    }]);



