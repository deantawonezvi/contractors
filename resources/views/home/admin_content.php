<div class="container" ng-app="adminApp" ng-cloak>
    <div class="center">
        <img src="img/linear-communication/svg/admin.svg" alt="admin" width="10%">
    </div>

    <div class="banner shadow-1" style="margin-top: 50px;">
        <h2>
            <a class="blue-text" href="/"><i class="fa fa-home"></i> Home</a>
            <i class="fa fa-angle-right"></i>
            <span>Admins</span>
        </h2>
    </div>

    <hr class="divider-icon">
    <div>
        <a class="btn btn-flat" href="/organisations"><i class="fa fa-user"></i> ORGANISATIONS</a>
        <a class="btn btn-flat" href="/sub-contractors"><i class="fa fa-group"></i> SUB CONTRACTORS</a>
    </div>
    <hr>
    <div class="row" ng-controller="mainCtrl">
        <div class="col-sm-12">
            <div class="card-large card-default card-body">
                <h3 class="left">ADMINISTRATORS [{{admins.length}}]</h3>

                <h3 class="right"><a class="clickable" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle blue-text"></i></a></h3>
                <br>
                <table class="responsive-table bordeblue striped">
                    <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Email Address
                        </th>
                        <th>
                            Organisation Name
                        </th>
                        <th>
                            Role
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="admin in admins" ng-dblclick="open(admin)">
                        <td>
                            {{admin.name}}
                        </td>
                        <td>
                            {{admin.email}}
                        </td>
                        <td>
                            {{admin.organisation.name || admin.sub_contractor.name }}
                        </td>
                        <td>
                            {{admin.role}}
                        </td>

                        <td class="right">
                            <button class="btn blue darken-4 white-text" ng-click="delete(admin)"><i
                                    class="fa fa-trash"></i></button>
                        </td>

                    </tr>
                    </tbody>

                </table>

            </div>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">ADD ADMIN</h4>
                    </div>
                    <div class="modal-body">
                        <form id="addAdminForm" ng-submit="add()">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" ng-model="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address:</label>
                                <input type="email" class="form-control" id="email" ng-model="email" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select name="role" id="role" class="form-control" ng-model="role"  required>
                                    <option value="organisation">Organisation - General</option>
                                    <option value="finance">Organisation - Finance</option>
                                    <option value="sub_contractor">Sub Contractor - General</option>
                                    <option value="sub_contractor_finance">Sub Contractor - Finance</option>
                                </select>
                            </div>
                            <div ng-if="role == 'organisation' || role == 'finance'" class="form-group">
                                <label for="organisation_id">Organisation</label>
                                <select name="organisation_id" id="organisation_id"  ng-model="organisation_id" class="form-control" required>
                                    <option ng-repeat="org in orgs" value="{{org.id}}">{{org.name}}</option>
                                </select>
                            </div>
                            <div ng-if="role == 'sub_contractor' || role == 'sub_contractor_finance'" class="form-group">
                                <label for="sub_contractor">Sub Contractor</label>
                                <select name="sub_contractor" id="sub_contractor" ng-model="sub_contractor" class="form-control">

                                    <option ng-repeat="sub in subs" value="{{sub.id}}">{{sub.name}}</option>
                                </select>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary blue white-text">Save
                            changes <i ng-show="loader" class="fa fa-spin fa-spinner"></i></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Edit Admin Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" ng-click="closeEdit()" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">EDIT ADMIN</h4>
                    </div>
                    <div class="modal-body">
                        <form id="editAdminForm" ng-submit="updateAdmin()">
                            <div class="form-group">
                                <label for="name">Admin Name:</label>
                                <input type="text" class="form-control" id="name" ng-model="adminE.name" required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Admin Model:</label>
                                <input type="text" class="form-control" id="model" ng-model="adminE.model"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Admin Driver</label>
                                <select name="driver" id="driver" class="search-select" ng-model="adminE.driver" ng-options="driver.name for driver in drivers track by driver.id" required>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="contact">Admin Defect</label>
                                <input type="text" class="form-control" id="model" ng-model="adminE.defect"
                                       required>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" ng-click="closeEdit()"
                                data-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary blue white-text">Save changes <i
                                ng-show="loader" class="fa fa-spin fa-spinner"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>

</div>
