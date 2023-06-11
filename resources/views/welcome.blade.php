<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap Table with Add and Delete Row Feature</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
    color: #404E67;
    background: #F5F7FA;
    font-family: 'Open Sans', sans-serif;
}
.table-wrapper {
    width: 850px;
    margin: 30px auto;
    background: #fff;
    padding: 20px;	
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {
    padding-bottom: 10px;
    margin: 0 0 10px;
}
.table-title h2 {
    margin: 6px 0 0;
    font-size: 22px;
}
.table-title .add-new {
    float: right;
    height: 30px;
    font-weight: bold;
    font-size: 12px;
    text-shadow: none;
    min-width: 100px;
    border-radius: 50px;
    line-height: 13px;
}
.table-title .add-new i {
    margin-right: 4px;
}
table.table {
    table-layout: fixed;
}
table.table tr th, table.table tr td {
    border-color: #e9e9e9;
}
table.table th i {
    font-size: 13px;
    margin: 0 5px;
    cursor: pointer;
}
table.table th:last-child {
    width: 135px;
}
table.table td a {
    cursor: pointer;
    display: inline-block;
    margin: 0 5px;
    min-width: 35px;
}    
table.table td a.add {
    color: #27C46B;
}
table.table td a.edit {
    color: #FFC107;
}
table.table td a.delete {
    color: #E34724;
}
table.table td i {
    font-size: 19px;
}
table.table td a.add i {
    font-size: 24px;
    margin-right: -1px;
    position: relative;
    top: 3px;
}    
table.table .form-control {
    height: 32px;
    line-height: 32px;
    box-shadow: none;
    border-radius: 2px;
}
table.table .form-control.error {
    border-color: #f50000;
}
table.table td .add {
    display: none;
}
</style>
</head>
<body>
<div class="container-lg">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Pacientes <b>Detalle</b></h2></div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-info add-new" href="#addEmployeeModal" data-toggle="modal"><i class="fa fa-plus"></i> Add New</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-8">
                        <form action="{{ action('App\Http\Controllers\PacientesController@index') }}" method="GET">
                            <div class="btn-group" data-toggle="buttons">
                                <input class="btn btn-info active" type="submit" name="edades" value="Todos" checked="checked">
                                <input class="btn btn-success" type="submit" name="edades" value="Niños">
                                <input class="btn btn-warning" type="submit" name="edades" value="Adultos">
                                <input class="btn btn-danger" type="submit" name="edades" value="Mayores">						
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <h2> <b>Filtro:</b> {{ $edades }}</h2>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha de nacimiento</th>
                        <th>Género</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $paciente)
                    <tr>
                        <td>{{ $paciente->nombre }}</td>
                        <td>{{ $paciente->fecha_nacimiento }}</td>
                        <td>{{ $paciente->genero }}</td>
                        <td>
                            <button type="submit" class="btn btn-warning" href="#editEmployeeModal-{{ $paciente->id }}" data-toggle="modal"><i class="fa fa-pencil"></i></button>
                        </td>
                        <td>
                        <form action="{{ action('App\Http\Controllers\PacientesController@destroy', $paciente->id) }}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ @csrf_field() }}
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Esta seguro de eliminar?')"><i class="fa fa-trash"></i></button>
                        </form>
                        </td>
                    </tr>
                    <div id="editEmployeeModal-{{ $paciente->id }}" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <form class="needs-validation" novalidate method="POST" action="{{ action('App\Http\Controllers\PacientesController@update', $paciente->id) }}">
                                {{ method_field('PUT') }}
                                {{ @csrf_field() }}
                                    <div class="modal-header">						
                                        <h4 class="modal-title">Editar Paciente</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">					
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" name="nombre" class="form-control" value="{{ $paciente->nombre}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha de nacimiento</label>
                                            <input type="text" name="fecha_nacimiento" class="form-control" value="{{ $paciente->fecha_nacimiento}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Género</label>
                                            <input type="text" name="genero" class="form-control" value="{{ $paciente->genero}}" required>
                                        </div>				
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                        <input type="submit" class="btn btn-success" value="Guardar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="needs-validation" novalidate method="POST" action="{{ url('/store') }}">
            {{ @csrf_field() }}
                <div class="modal-header">						
					<h4 class="modal-title">Agregar Paciente</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="nombre" class="form-control" required placeholder="Nombre completo">
					</div>
					<div class="form-group">
						<label>Fecha de nacimiento</label>
						<input type="text" name="fecha_nacimiento" class="form-control" required placeholder="0000-00-00">
					</div>
					<div class="form-group">
						<label>Género</label>
						<input type="text" name="genero" class="form-control" required placeholder="Mujer/Hombre">
					</div>				
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Guardar">
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>