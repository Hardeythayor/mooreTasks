@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div id="msg" class="alert alert-success d-none">
                    <strong>Success!</strong> Task created successfully
                </div>
                <div id="msg2" class="alert alert-success d-none">
                    <strong>Success!</strong> Task Updated successfully
                </div>
                <div id="msg3" class="alert alert-success d-none">
                    <strong>Success!</strong> Task Deleted successfully
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
                                {{ __('Tasks') }}
                            </div>

                            <form class="mb-5 mt-3 text-center-md">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="all" name="status"
                                        value="" checked>
                                    <label class="custom-control-label" for="all">All</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="pending" name="status"
                                        value="pending">
                                    <label class="custom-control-label" for="pending">Pending</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="in_progress" name="status"
                                        value="in_progress">
                                    <label class="custom-control-label" for="in_progress">In progress</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="completed" name="status"
                                        value="completed">
                                    <label class="custom-control-label" for="completed">Completed</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="cancelled" name="status"
                                        value="cancelled">
                                    <label class="custom-control-label" for="cancelled">Cancelled</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="backlog" name="status"
                                        value="backlog">
                                    <label class="custom-control-label" for="backlog">Backlog</label>
                                </div>
                                <button id="filter" type="button"
                                    class="btn mt-3 mt-md-0 btn-primary btn-sm px-4">Filter</button>
                            </form>
                        </div>

                        <div class="float-right px-md-5 mb-3">
                            <button class="btn btn-outline-primary btn-lg px-md-4" data-toggle="modal" data-target="#addTask"> 
                                <i class="fa fa-plus mr-2"></i>
                                New Task
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordeless table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">S/N</th>
                                        <th>Task ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th width="15%">Due date</th>
                                        <th width="30%">Action</th>
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

        <!-- Add new task modal -->
            <!-- The Modal -->
            <div id="addTask" class="modal fade" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <form id="submitTask">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add New Task</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                    
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control form-control-lg" id="title"  required>
                                        </div>
                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <textarea class="form-control form-contol-lg" rows="5" id="description" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="priority">Priority Level</label>
                                            <select class="form-control form-control-lg" id="priority" required>
                                                <option value="">--select--</option>
                                                <option value="high">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="dueDate">Due Date</label>
                                            <input type="date" class="form-control form-control-lg" id="dueDate"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success px-4">Save</button>
                            </div>
                        </form>
                
                    </div>
                </div>
            </div>

        <!-- End of create modal -->

        <!-- Edit task modal -->
            <!-- The Modal -->
            <div id="editTask" class="modal fade">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <form id="updateTask">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Task</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                    
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="hidden" class="form-control form-control-lg" id="taskId">

                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control form-control-lg" id="title"  required>
                                        </div>
                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <textarea class="form-control form-contol-lg" rows="5" id="description" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control form-control-lg" id="status" required>
                                                <option value="">--select--</option>
                                                <option value="pending">Pending</option>
                                                <option value="in_progress">In progress</option>
                                                <option value="completed">Completed</option>
                                                <option value="backlog">Backlog</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="priority">Priority Level</label>
                                            <select class="form-control form-control-lg" id="priority" required>
                                                <option value="">--select--</option>
                                                <option value="high">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="dueDate">Due Date</label>
                                            <input type="date" class="form-control form-control-lg" id="dueDate"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success px-4">Update</button>
                            </div>
                        </form>
                
                    </div>
                </div>
            </div>

        <!-- End of edit modal -->


        <script>
            //  create new task functionality
            const form  = document.getElementById('submitTask');

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                const title = form.elements['title'].value
                const description = form.elements['description'].value
                const priority = form.elements['priority'].value
                const dueDate = form.elements['dueDate'].value

                const task = {
                    title, description, priority, dueDate
                }

                createTask(task)
            });

            //  update task functionality
            const updateForm  = document.getElementById('updateTask');

            updateForm.addEventListener('submit', (event) => {
                event.preventDefault();
                const taskId = updateForm.elements['taskId'].value
                const title = updateForm.elements['title'].value
                const description = updateForm.elements['description'].value
                const priority = updateForm.elements['priority'].value
                const dueDate = updateForm.elements['dueDate'].value
                const status = updateForm.elements['status'].value


                const task = {
                    taskId, title, description, priority, dueDate, status
                }

                updateTask(task)
            });

            // function to add new task
            function createTask(task) {
                $.ajax({
                    url: '/tasks/create',
                    method: "POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        ...task
                    },
                    success: function(data){
                        $("#addTask .close").click()
                        $("#msg" ).removeClass( "d-none" ).addClass("d-block" );
                        form.reset()
                        $('#tdata').empty()
                        fetchTasks()
                    }
                })
            }

            // function to update task
            function updateTask(task) {
                let c = $('input[name="status"]:checked').val();

                $.ajax({
                    url: '/tasks/update/' + task.taskId,
                    method: "PUT",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        ...task
                    },
                    success: function(data){
                        $("#editTask").modal("hide")
                        $("#msg2" ).removeClass( "d-none" ).addClass("d-block" );
                        form.reset()
                        $('#tdata').empty()
                        fetchTasks(c)
                    }
                })
            }

            // function to update task
            function deleteTask(id) {

                $.ajax({
                    url: '/tasks/delete/' + id,
                    method: "DELETE",
                    data:{
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data){
                        $("#msg3" ).removeClass("d-none" ).addClass("d-block" );
                        form.reset()
                        $('#tdata').empty()
                        fetchTasks()
                    }
                })
            }

            //  function to oped edit task modal
            function showUpdateModal(id) {
                const form  = document.getElementById('updateTask');
                $.ajax({
                    url: '/tasks/admin/fetch/' + id,
                    method: "GET",
                    data:{
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data){
                        form.elements['taskId'].value = data.id
                        form.elements['title'].value = data.title
                        form.elements['description'].value = data.description
                        form.elements['priority'].value = data.priority
                        form.elements['dueDate'].value = data.due_date
                        form.elements['status'].value = data.status
                        $("#editTask").modal('show')
                    }
                })
            }

            //  fetch tasks based on selected filter
            $("#filter").click(function() {
                let c = $('input[name="status"]:checked').val();
                $('#tdata').empty()
                fetchTasks(c)
            });

            //  function to fetch task
            function fetchTasks(status = null) {
                $.ajax({
                    url: '/tasks/admin/fetch',
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        status: status
                    },
                    success: function(data) {
                        if (data.length) {
                            data.forEach((task, i) => {
                                let priority_badge = task.priority == 'high' ? 'badge-danger' : task.priority == 'medium' ? 'badge-warning' : 'badge-secondary'
                                let status_badge = task.status == 'pending' ? 'badge-warning' : 
                                            task.status == 'in_progress' ? 'badge-info' : 
                                            task.status == 'in_cancelled' ? 'badge-danger' : 
                                            task.status == 'backlog' ? 'badge-dark' : 
                                            task.status == 'completed' ? 'badge-success' : 
                                            'badge-secondary'
                                let status_text = task.status == 'in_progress' ? 'Progress' : task.status

                                $('#tdata').append(
                                    "<tr>" +
                                        "<td>" + (i + 1) + "</td>" +
                                        "<td>" + task.task_id + "</td>" +
                                        "<td>" + task.title + "</td>" +
                                        "<td>" + task.description + "</td>" +
                                        `<td class='text-uppercase'><span class='badge ${status_badge}'>${status_text}</span></td>`+
                                        `<td class='text-uppercase'><span class='badge ${priority_badge}'>${task.priority}</span></td>`+
                                        "<td>" + task.due_date + "</td>" +
                                        `<td>
                                            <button class='btn btn-sm btn-success mr-2' onClick="showUpdateModal('${task.id}')">
                                                <i class='fa fa-edit'></i>
                                            </button>
                                            <button class='btn btn-sm btn-danger' onClick="deleteTask('${task.id}')">
                                                <i class='fa fa-trash'></i>
                                            </button>
                                        </td>` +
                                    "</tr>"
                                )
                            });
                        } else {
                            $('#tdata').append(
                                "<tr>" +
                                `<td colspan='8'>
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

            //  invoke fetch task function
            fetchTasks();
        </script>
    </div>
@endsection
