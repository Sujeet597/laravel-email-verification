@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                      <div id="status-message" class="alert alert-success" role="alert">
                       {{ session('status') }}
                      </div>
                   @endif

                    {{ __('Hello!,') }}
                    <h1>{{ Auth::user()->name }}</h1>
                    <h3>Your Tasks</h3>
                    @if($tasks->isEmpty())
                        <p>No tasks found.</p>
                    @else
                        <ul class="list-group">
                            @foreach($tasks as $task)
                               <li class="list-group-item d-flex align-items-center justify-content-between">
                                 <div>
                                    <strong>{{ $task->task }}</strong>
                                    <span class="badge {{ $task->status == 'pending' ? 'text-danger' : 'text-primary' }}">
                                      {{ $task->status }}
                                    </span>
                                 </div>
                                 @if($task->status == 'pending')
                                 <button class="btn btn-success btn-sm mark-done" data-task-id="{{ $task->id }}">Done</button>
                                  @else
                                 <button class="btn btn-warning btn-sm mark-pending" data-task-id="{{ $task->id }}">Pending</button>
                             @endif
                              </li>
                           @endforeach
                         </ul>
                     @endif
                     <h2>Add New Task</h2>
                     <form action="" method="POST">
                         @csrf
                         <div class="form-group">
                             <label for="task">Task</label>
                             <input type="text" name="task" id="task" class="form-control" required>
                         </div>
                         <button type="submit" class="btn btn-primary mt-3">Add Task</button>
                     </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#task-form').on('submit', function(e) {
    e.preventDefault();

    var task = $('#task').val();

    $.ajax({
        url: '{{ route('task.store') }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            task: task
        },
        success: function(response) {
            if (response.status === 1) {
                $('#header-message').text(response.message).fadeIn();
                setTimeout(function() {
                    $('#header-message').fadeOut('slow', function() {
                        $(this).text(''); // Clear the message text
                    });
                }, 1000); // Remove message after 1 second
            } else {
                alert(response.message);
            }
        },
        error: function(response) {
            alert('Error: ' + response.responseJSON.message);
        }
    });
});



        $('.mark-done').click(function() {
            var taskId = $(this).data('task-id');
            if (confirm('Are you sure you want to mark this task as done?')) {
            $.ajax({
                url: '/tasks/' + taskId + '/update',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 1) {
                        $('#header-message').text(response.message).fadeIn();
                        setTimeout(function() {
                            window.location.href = '/home'; // Redirect to home page
                        }, 500); // Redirect after 0.5 second
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                }
            });
        }
        });
        $('.mark-pending').click(function() {
            var taskId = $(this).data('task-id');
            if (confirm('Are you sure you want to mark this task as pending?')) {
                $.ajax({
                    url: '/tasks/' + taskId + '/update',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 1) {
                            $('#header-message').text('Task marked as pending').fadeIn();
                            setTimeout(function() {
                                window.location.href = '/home'; // Redirect to home page
                            }, 500); // Redirect after 2 seconds
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message);
                    }
                });
            }
        });

    });
</script>
@endsection
