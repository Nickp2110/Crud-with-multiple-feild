<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 8 Add/Remove Multiple Input Fields Example</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <style>
      .container {
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div>
        {{-- Add popup --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('store-input-fields') }}" method="POST">
                            @csrf
                            <table class="table w-100" id="dynamicAddRemove">
                                <tr>
                                    <td>name</td>
                                    <td><input type="hidden" name="id" placeholder="Auto" class="form-control"/>
                                        <input type="text" name="name" placeholder="Enter Name" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td>email</td>
                                    <td><input type="text" name="email" placeholder="Enter email" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td>Subject</td>
                                    <td><input type="text" name="subject[0]" placeholder="Enter subject" class="form-control" /></td>
                                    <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add subject</button></td>
                                    <td id="dynamicAddRemove"></td>
                                </tr>
                            </table>
                            <button type="submit" class="btn btn-outline-success btn-block">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Edit popup --}}
        <div class="modal fade" id="staticBackdrop">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit data</h5>
                    </div>
                    <div class="modal-body">
                        <table id="editform" class="w-100">
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- view popup --}}
        <div class="modal fade" id="viewsubjectpopup">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Subject data</h5>
                        <button type="button" class="btn btn-danger ml-5" data-bs-dismiss="modal">Close</button>
                    </div>
                    <div class="modal-body">
                        <table id="view" class="w-100">
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Table --}}
        <div class="container w-100 mt-3">
            <table id="datatable" class="table table-border mt-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Data</button>
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Subject</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody class="tabledata">
                </tbody>
            </table>
        </div>
    </div>
</body>
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td>Subject</td><td><input type="text" name="subject['+i+']" placeholder="Enter subject" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
            );
    });

    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });

    $(document).ready(function(){
        employeeList();
    })

    //view data
    function employeeList() {
        $.ajax({
            type: 'GET',
            url: "{{ url('/view') }}",
            success: function(response) {
                var user_id = response[1][0].user_id;
                console.log(user_id);
                var tr = '';
                for (var i = 0; i < response[0].length; i++) {
                    var id = response[0][i].id;
                    var name = response[0][i].name;
                    var email = response[0][i].email;
                    tr += '<tr>';
                    tr += '<td>' + id + '</td>';
                    tr += '<td>' + name + '</td>';
                    tr += '<td>' + email + '</td>';
                    tr += '<td>'
                    for (var j = 0; j < response[1].length; j++){
                        var user_id = response[1][j].user_id;
                        var subject = response[1][j].subject;
                        if(id == user_id){
                            tr += '' + subject + ',<br>';
                        }
                    }
                    tr += '</td>'
                    tr += '<td><button href="#viewsubjectpopup" class="btn btn-primary type="button" onclick="viewsubject('+id+')" data-bs-toggle="modal" data-bs-target="#viewsubjectpopup">View</button>&nbsp;';
                    tr += '<button href="#staticBackdrop" class="btn btn-primary edit" type="button" onclick="editid('+id+')" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Edit</button>&nbsp;';
                    tr += '<a class="btn btn-danger" onclick="deletedata('+id+')">Del</a></td>';
                    tr += '</tr>';
                }
                // var tr = '';
                // for (var i = 0; i < response.length; i++) {
                //     var id = response[i].id;
                //     var name = response[i].name;
                //     var email = response[i].email;
                //     tr += '<tr>';
                //     tr += '<td>' + id + '</td>';
                //     tr += '<td>' + name + '</td>';
                //     tr += '<td>' + email + '</td>';
                //     tr += '<td><button href="#viewsubjectpopup" class="btn btn-primary type="button" onclick="viewsubject('+id+')" data-bs-toggle="modal" data-bs-target="#viewsubjectpopup">View Subject</button></td>';
                //     tr += '<td><button href="#staticBackdrop" class="btn btn-primary edit" type="button" onclick="editid('+id+')" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Edit</button>';
                //     tr += '<a class="btn btn-danger" onclick="delete('+id+')">Delete</a></td>';
                //     tr += '</tr>';
                // }
                $('.tabledata').html(tr);
            }
        });
    }

    //edit form
    function editid(id){
        $.ajax({
            type: 'get',
            data: {id:id},
            url: "{{ url('add') }}",
            success: function(response) {
                var tr = '';
                tr += '<input type="hidden" id="id" placeholder="Auto" class="form-control" value="'+response[0].id+'"/>';
                tr += '<tr><td>Name</td><tr></tr><td><input type="text" id="name" placeholder="Enter name" class="form-control" value="'+response[0].name+'"/></td></tr>';
                tr += '<tr><td>Email</td><tr></tr><td><input type="email" id="email" placeholder="Enter email" class="form-control" value="'+response[0].email+'"/></td></tr>';
                tr += '<tr><td>Subject</td></tr>'
                for (var i = 0; i < response.length; i++){
                    tr += '<tr><td><input type="text" id="subject'+i+'" placeholder="Enter subject" class="form-control" value="'+response[i].subject+'"/></td></tr>';
                }
                tr += '<div class="addsubmitfield"></div>'
                tr += '<tr><td><button type="button" name="add" id="dynamic" class="btn btn-outline-primary">Add subject</button></td></tr>'
                tr += '<input type="submit" onclick="editsubmit()" class="btn btn-primary" data-bs-dismiss="modal" value="submit">'
                tr += '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>'
                $('#editform').html(tr);
                var i = response.length-1;
                $('#dynamic').click(function(){
                    ++i;
                    $('.addsubmitfield').append('<tr><td><input class="form-control" type="text" id="subject'+i+'" placeholder="Enter subject"/><button type="button" class="btn btn-outline-danger remove-input-field1">Delete</button></td></tr>');
                })
                $(document).on('click', '.remove-input-field1', function () {
                    $(this).parents('tr').remove();
                });
            }
        })
    }

    //submit edit form
    function editsubmit(){
        var id = $('#id').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var subject = new Array(100);
        for (let i = 0; i < 100; i++) {
            if(($('#subject'+i).val())==""){
                break;
            }
            subject[i] = $('#subject'+i).val();
        }
        $.ajax({
            url:"{{url('update')}}",
            type:"POST",
            data:{_token:"{{ csrf_token() }}",id:id,name:name,email:email,subject:subject},
            success:function(response){
                // console.log(response);
                $('#staticBackdrop').modal('hide');
                // redirect();
                // window.location.href = "/";
                employeeList();
            }
        })
    }

    //view subject from tabledata
    function viewsubject(id){
        // $.ajax({
        //     type: 'get',
        //     data: {id:id},
        //     url: "{{ url('viewsubject') }}",
        //     success: function(response) {
        //         var tr = '';
        //         tr += '<input type="hidden" id="id" placeholder="Auto" class="form-control" value="'+response[0].id+'"/>';
        //         for (var i = 0; i < response.length; i++){
        //             tr += '<tr><td>'+response[i].subject+'</td></tr>';
        //         }
        //         // tr += '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>'
        //         $('#view').html(tr);
        //     }
        // })
        $.ajax({
            type: 'get',
            data: {id:id},
            url: "{{ url('viewsubject') }}",
            success: function(response) {
                var tr = '';
                tr += '<input type="hidden" id="id" placeholder="Auto" class="form-control" value="'+response[0].id+'"/>';
                tr += '<tr><td>Name :</td><td>'+response[0].name+'</td></tr>';
                tr += '<tr><td>Email :</td><td>'+response[0].email+'</td></tr>';
                // tr += '<tr><td>Email</td><tr></tr><td><input type="email" id="email" placeholder="Enter email" class="form-control" value="'+response[0].email+'"/></td></tr>';
                tr += '<tr><td>Subject :</td><td>'
                for (var i = 0; i < response.length; i++){
                    tr += ''+response[i].subject+' ,';
                }
                tr += '</td></tr>'
                $('#view').html(tr);
            }
        })
    }

    //delete
    function deletedata(id){
        $.ajax({
            type: 'get',
            data: {id:id,_token:"{{ csrf_token() }}"},
            url: "{{ url('delete') }}",
            success: function(response) {
                employeeList();
            }
        })
    }

</script>
</html>
