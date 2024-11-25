<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div id="userDiv" class="d-none">
        <h2>User Form</h2>
        <form id="userForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" >
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" >
                </div>
                <div class="mb-3 col-md-6">
                    <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" >
                </div>
                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="role_id" class="form-label">Role</label>
                    <select class="form-select" id="role_id" name="role_id" >
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                </div>
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>
        <hr>
    </div>
    <div id="table-div">
        <button type="button" id="addUser" class="btn btn-primary mb-3">Add User</button>
        <h2>User List</h2>
        <table id="userTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Profile Image</th>
                </tr>
            </thead>
            <tbody id="data">
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->role->role_name}}</td>
                        <td><img src="{{$user->profile_image ? asset('profile_image/'.$user->profile_image) : ''}}" width="100px;"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        

        $('#addUser').click(function(){
            $('#table-div').addClass('d-none');
            $('#userDiv').removeClass('d-none');
        });

        const userTable = $('#userTable').DataTable();

        function fetchUsers() {
            let url = "{{route('users.fetch_users')}}";
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#data').html(data);
                    
                },
                
            });
        }

        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            let url = "{{route('users.store')}}"
            let formData = new FormData(this);

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    
                    alert('User added successfully!');
                    fetchUsers();
                    $('#userForm')[0].reset();
                    $('#userDiv').addClass('d-none');
                    
                    $('#table-div').removeClass('d-none');
                },
                error: function(xhr) {
                    
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        
                        $('.invalid-feedback').remove();
                        $('.is-invalid').removeClass('is-invalid');

                        
                        for (const field in errors) {
                            const input = $(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                        }
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                }
            });
        });
    });
</script>
</body>
</html>
