@foreach($users as $user)
    <tr>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->phone}}</td>
        <td>{{$user->role->role_name}}</td>
        <td><img src="{{$user->profile_image ? asset('profile_image/'.$user->profile_image) : ''}}" width="100px;"></td>
    </tr>
@endforeach