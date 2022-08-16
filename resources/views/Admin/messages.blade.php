@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h5 class="font-weight-bold">{{ __('All Messages') }}</h5></div>

                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th width="5%">S/N</th>
                                <th>User's Fullname</th>
                                <th>Message</th>
                                <th width="18%">Date & Time</th>
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
        // $(document).ready(function(){
            $("#filter").click(function(){
                let c =  $('input[name="status"]:checked').val();
                $('#tdata').empty()
                fetchUsers(c)
            });

            function fetchUserMessages() {
                $.ajax({
                    url: '/messages/admin/fetch',
                    method: "GET",
                    data:{
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data){
                        if(data.length) {
                            data.forEach((msg, i) => {
                                    $('#tdata').append(
                                        "<tr>" +
                                            "<td>"+ (i + 1) +"</td>" +
                                            "<td>"+ msg.user.name +"</td>" +
                                            "<td>"+ msg.message +"</td>" +
                                            "<td>"+ msg.date_created +"</td>"
                                        + "</tr>"
                                    )
                            });
                        } else {
                            $('#tdata').append(
                                "<tr>" +
                                    `<td colspan='6'>
                                        <div class="alert alert-info text-center">
                                            <h4>No RECORD FOUND</h4>
                                        </div>
                                    </td>`
                                + "</tr>"
                            )
                        }
                    }
                })
            }

            fetchUserMessages();
        // });

    </script>
</div>
@endsection
