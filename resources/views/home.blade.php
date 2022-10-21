@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div id="msgDiv" class="alert alert-success d-none">
                <strong>Success!</strong> Message sent successfully
            </div>
            <div class="card shadow-lg">
                <div class="card-header">
                    <h5 class="font-weight-bold">New Message to Admin</h5>
                </div>
                <div class="card-body">
                    <form>
                        <label for="message">Type your Message</label>
                        <textarea name="message" class="form-control" id="message" cols="30" rows="7"></textarea>
                        <div class="text-right mt-4">
                            <button type="button" id="send" class="btn btn-primary btn-sm px-5">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold">All Sent Messages</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-sm">
                            <thead>
                              <tr>
                                <th width="5%">S/N</th>
                                <th width="60%">Message</th>
                                <th>Date & Time</th>
                              </tr>
                            </thead>
                            <tbody id="tmsg">

                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sendMessage(message) {
            $.ajax({
                url: '/messages/send',
                method: "POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    message: message,
                },
                success: function(data){
                    $( "#msgDiv" ).removeClass( "d-none" ).addClass( "d-block" );
                    $('#message').val('')
                    $('#tmsg').empty()
                    fetchMessages()
                }
            })
        }

        $("#send").click(function(){
            let msg =  $('#message').val();
            sendMessage(msg);
        });

        function fetchMessages() {
                $.ajax({
                    url: '/messages',
                    method: "GET",
                    data:{
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data){
                        if(data.length) {
                            data.forEach((msg, i) => {
                                    $('#tmsg').append(
                                        "<tr>" +
                                            "<td>"+ (i + 1) +"</td>" +
                                            "<td>"+ msg.message +"</td>" +
                                            "<td>"+ msg.date_created +"</td>"
                                        + "</tr>"
                                    )
                            });
                        } else {
                            $('#tmsg').append(
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

            fetchMessages();

    </script>
</div>
@endsection
