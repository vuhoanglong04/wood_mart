<table>
    <thead>
        <tr>
            <th style="font-size:16px;width: 200px;font-weight:bolder">Email</th>
            <th style="font-size:16px;width: 200px;font-weight:bolder">Phone Number</th>
            <th style="font-size:16px;width: 200px;font-weight:bolder">Full Name</th>
            <th style="font-size:16px;width: 200px;font-weight:bolder">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
