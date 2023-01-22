<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRUD ' WEB</title>

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />

</head>

<body class="bg-light">
{{-- Add new Student --}}
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel"data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>

<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>
<form action="#" method="POST" id="add_student_form" enctype="multipart/form-data"autocomplete="off">
@csrf
<div class="modal-body p-4 bg-light">
<div class="row">
<div class="col-lg">
<label for="nombre">Nombres</label>
<input type="text" name="nombre" class="form-control" placeholder="Nombres"required>
</div>
<div class="col-lg">
<label for="apellido">Apellidos</label>
<input type="text" name="apellido" class="form-control" placeholder="Apellidos"required>
</div>
</div>
<div class="my-2">
<label for="email">E-mail</label>
<input type="email" name="email" class="form-control" placeholder="E-mail"required>
</div>
<div class="my-2">
<label for="telefono">Teléfono</label>
<input type="tel" name="telefono" class="form-control" placeholder="telefono"required>
</div>
<div class="my-2">
<label for="sexo">Sexo</label>
<input type="text" name="sexo" class="form-control" placeholder="Sexo" required>
</div>
<div class="my-2">
<label for="foto">Select Avatar</label>
<input type="file" name="foto" class="form-control" required>
</div>
</div>
<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

<button type="submit" id="add_student_btn" class="btn btn-primary">Add
Student</button>
</div>
</form>
</div>
</div>
</div>
{{-- add new Student modal end --}}
{{-- edit Student modal start --}}

<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>

<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>
<form action="#" method="POST" id="edit_student_form" enctype="multipart/form-data">
@csrf
<input type="hidden" name="student_id" id="student_id">
<input type="hidden" name="student_foto" id="student_foto">
<div class="modal-body p-4 bg-light">
<div class="row">
<div class="col-lg">
<label for="nombre">Nombres</label>
<input type="text" name="nombre" id="nombre" class="form-control"placeholder="Nombres" required>
</div>
<div class="col-lg">
<label for="apellido">Apellido</label>
<input type="text" name="apellido" id="apellido" class="form-control"placeholder="Apellidos" required>
</div>
</div>
<div class="my-2">
<label for="email">E-mail</label>

<input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>

</div>
<div class="my-2">
<label for="phone">Teléfono</label>
<input type="tel" name="telefono" id="telefono" class="form-control"placeholder="Teléfono" required>
</div>
<div class="my-2">
<label for="sexo">Sexo</label>
<input type="text" name="sexo" id="sexo" class="form-control" placeholder="Sexo"required>
</div>
<div class="my-2">
<label for="foto">Foto</label>
<input type="file" name="foto" class="form-control">
</div>
<div class="mt-2" id="foto">
</div>
</div>
<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

<button type="submit" id="edit_student_btn" class="btn btn-success">UpdateStudent</button>
</div>
</form>
</div>
</div>
</div>
{{-- edit Student modal end --}}
<div class="container">
<div class="row my-5">
<div class="col-lg-12">
<div class="card shadow">
<div class="card-header bg-primary d-flex justify-content-between align-items-center">
<h3 class="text-light">Manage Student</h3>

<button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addStudentModal"><i class="bi-plus-circle me-2"></i>Add New Student</button>

</div>
<div class="card-body" id="show_all_students">
<h1 class="text-center text-secondary my-5">Loading...</h1>
</div>
</div>
</div>
</div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function() {
// add new employee ajax request
$("#add_student_form").submit(function(e) {
e.preventDefault();
const fd = new FormData(this);
$("#add_student_btn").text('Adding...');
$.ajax({
url: "{{route('store')}}",
method: 'post',
data: fd,
cache: false,
contentType: false,
processData: false,
dataType: 'json',
success: function(response) {
if (response.status == 200) {
Swal.fire(
'Added!',
'Student Added Successfully!',
'success'
)
fetchAllStudent();
}
$("#add_student_btn").text('Add Student');
$("#add_student_form")[0].reset();
$("#addStudentModal").modal('hide');
}
});
});
// edit employee ajax request
$(document).on('click', '.editIcon', function(e) {
e.preventDefault();
let id = $(this).attr('id');
$.ajax({
url: "{{ route('edit') }}",
method: 'get',
data: {
id: id,
_token: '{{ csrf_token() }}'
},
success: function(response) {
$("#nombre").val(response.nombre);
$("#apellido").val(response.apellido);
$("#email").val(response.email);
$("#telefono").val(response.telefono);
$("#sexo").val(response.sexo);
$("#foto").html(

`<img src="storage/images/${response.foto}" width="100" class="img-fluid img-thumbnail">`);

$("#student_id").val(response.id);
$("#student_foto").val(response.foto);
}
});
});
// update employee ajax request
$("#edit_student_form").submit(function(e) {
e.preventDefault();
const fd = new FormData(this);
$("#edit_student_btn").text('Updating...');
$.ajax({
url: "{{ route('update') }}",
method: 'post',
data: fd,
cache: false,
contentType: false,
processData: false,
dataType: 'json',
success: function(response) {
if (response.status == 200) {
Swal.fire(
'Updated!',
'Student Updated Successfully!',
'success'
)
fetchAllStudent();
}
$("#edit_student_btn").text('Update Student');
$("#edit_student_form")[0].reset();
$("#editStudentModal").modal('hide');
}
});
});
// delete employee ajax request
$(document).on('click', '.deleteIcon', function(e) {
e.preventDefault();
let id = $(this).attr('id');
let csrf = '{{ csrf_token() }}';
Swal.fire({
title: 'Are you sure?',
text: "You won't be able to revert this!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.isConfirmed) {
    $.ajax({
url: "{{ route('delete') }}",
method: 'delete',
data: {
id: id,
_token: csrf
},
success: function(response) {
console.log(response);
Swal.fire(
'Deleted!',
'Your file has been deleted.',
'success'
)
fetchAllStudent();
}
});
}
})
});
// fetch all student ajax request
fetchAllStudent();
function fetchAllStudent() {
$.ajax({
url: "{{ route('fetchAll') }}",
method: 'get',
success: function(response) {
$("#show_all_students").html(response);
$("table").DataTable({
order: [0, 'desc']
});
}
});
}
});
</script>
</body>
</html>