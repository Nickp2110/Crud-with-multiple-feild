{{-- <h3>{{ $query }}</h3> --}}
<table>
    <tr>
        <td>ID</td>
        <td>Subject</td>
        <td>User ID</td>
    </tr>
    @foreach($query as $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->subject }}</td>
            <td>{{ $value->user_id }}</td>
        </tr>
    @endforeach
</table>
