@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div id="msg" class="alert alert-success d-none">
                    <strong>Success!</strong> User Status updated successfully
                </div>
                <div class="card users-table">
                    <div>
                        <div class="px-md-5 pt-md-5">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="title">
                                {{ __('Users') }}
                            </div>

                            <form class="mb-5 mt-3 text-center-md">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="all" name="status"
                                        value="" checked>
                                    <label class="custom-control-label" for="all">All</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="active" name="status"
                                        value="active">
                                    <label class="custom-control-label" for="active">Active</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="pending" name="status"
                                        value="pending">
                                    <label class="custom-control-label" for="pending">Pending</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="inactive" name="status"
                                        value="inactive">
                                    <label class="custom-control-label" for="inactive">Inactive</label>
                                </div>
                                <button id="filter" type="button"
                                    class="btn mt-3 mt-md-0 btn-primary btn-sm px-4">Filter</button>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordeless table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">S/N</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tdata">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function updateUsers(status, id) {
                $.ajax({
                    url: '/users/change_status/' + id,
                    method: "PUT",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        status: status,
                    },
                    success: function(data) {
                        $("#msg").removeClass("d-none").addClass("d-block");
                        let c = $('input[name="status"]:checked').val();
                        $('#tdata').empty()
                        fetchUsers(c)
                    }
                })
            }
            // $(document).ready(function(){
            $("#filter").click(function() {
                let c = $('input[name="status"]:checked').val();
                $('#tdata').empty()
                fetchUsers(c)
            });

            function fetchUsers(status = null) {
                $.ajax({
                    url: '/users/fetch',
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        status: status
                    },
                    success: function(data) {
                        if (data.length) {
                            data.forEach((user, i) => {
                                let badge = user.status == 'pending' ? 'badge-warning' : user.status == 'active' ? 'badge-success' : 'badge-danger'

                                $('#tdata').append(
                                    "<tr>" +
                                    "<td>" + (i + 1) + "</td>" +
                                    "<td>" + user.name + "</td>" +
                                    "<td>" + user.email + "</td>" +
                                    "<td>" + user.phone + "</td>" +
                                    `<td class='text-uppercase'><span class='badge ${badge}'>${user.status}</span></td>`+
                                    `<td>
                                        ${user.status == 'active' ? `<button class='btn btn-sm btn-danger' onClick="updateUsers('inactive', '${user.id}')">Deactivate</button>` :
                                            `<button class='btn btn-sm btn-dark' onClick="updateUsers('active', '${user.id}')">Activate</button>`}
                                    </td>` +
                                    "</tr>"
                                )
                            });
                        } else {
                            $('#tdata').append(
                                "<tr>" +
                                `<td colspan='6'>
                                        <div class="alert alert-info text-center">
                                            <h4>No RECORD FOUND</h4>
                                        </div>
                                    </td>` +
                                "</tr>"
                            )
                        }
                    }
                })
            }

            fetchUsers();
            // });
        </script>
    </div>
@endsection
