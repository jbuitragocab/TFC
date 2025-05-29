<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de {{ $restaurante->nombre }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .nav-link {
            color: #fff;
        }

        .nav-item{
            color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils"></i> Admin: {{ $restaurante->nombre }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"><i class="fas fa-tachometer-alt"></i> Inicio <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4 text-center">Panel de Administración</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Información del Restaurante</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> {{ $restaurante->nombre }}</p>
                        <p><strong>Dirección:</strong> {{ $restaurante->direccion }}</p>
                        <p><strong>Teléfono:</strong> {{ $restaurante->telefono ?? 'N/A' }}</p>
                        <p><strong>Horario:</strong> {{ $restaurante->horario ?? 'N/A' }}</p>
                    </div>
                </div>
                <hr>
                <div class="text-right">
                    <a href="{{ route('admin_restaurante.edit')}}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit"></i> Editar Información
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-info text-white">
                <ul class="nav nav-tabs card-header-tabs" id="adminTabs" role="tablist">
                   
                    <li class="nav-item">
                        <a class="nav-link active" id="reservas-tab" data-toggle="tab" href="#reservas" role="tab" aria-controls="reservas" aria-selected="false">
                            <i class="fas fa-calendar-check"></i> Reservas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="mesas-tab" data-toggle="tab" href="#mesas" role="tab" aria-controls="mesas" aria-selected="false">
                            <i class="fas fa-chair"></i> Mesas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="menus-tab" data-toggle="tab" href="#menus" role="tab" aria-controls="menus" aria-selected="true">
                            <i class="fas fa-book-open"></i> Menús
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="adminTabsContent">
                    <div class="tab-pane " id="menus" role="tabpanel" aria-labelledby="menus-tab">
                        <h5 class="card-title">Gestión de Menús</h5>
                        <a href="#" class="btn btn-success btn-sm mb-3"><i class="fas fa-plus-circle"></i> Añadir Nuevo Menú</a>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nombre del Menú</th>
                                        <th>Tipo de Plato</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($restaurante->menus as $menu) --}}
                                    <tr>
                                        <td>Menú del Día</td>
                                        <td>Principal</td>
                                        <td>Plato combinado con opciones vegetarianas.</td>
                                        <td>12.50 €</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                            <button class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Menú Infantil</td>
                                        <td>Secundario</td>
                                        <td>Mini hamburguesa con patatas y bebida.</td>
                                        <td>7.00 €</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                            <button class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    {{-- @endforeach --}}
                                    {{-- Si no hay menús --}}
                                    {{-- @if ($restaurante->menus->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">No hay menús registrados para este restaurante.</td>
                                        </tr>
                                    @endif --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="mesas" role="tabpanel" aria-labelledby="mesas-tab">
                        <h5 class="card-title">Gestión de Mesas</h5>
                        <a href="{{ route('admin_restaurante.createMesa')}}" class="btn btn-success btn-sm mb-3"><i class="fas fa-plus-circle"></i> Añadir Nueva Mesa</a>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Mesa</th>
                                        <th>Capacidad</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($restaurante->mesas as $mesa)
                                    <tr>
                                        <td>{{ $mesa->identificador }}</td>
                                        <td>{{ $mesa->capacidad }} personas</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin_restaurante.editMesa', $mesa->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin_restaurante.destroyMesa', $mesa->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                            </form>

                                    @endforeach
                                     @if ($restaurante->mesas->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">No hay mesas registradas para este restaurante.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade show active" id="reservas" role="tabpanel" aria-labelledby="reservas-tab">
                        <h5 class="card-title">Gestión de Reservas</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Mesa</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Personas</th>
                                        <th>Importe</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($restaurante->reservas as $reserva)
                                    <tr>
                                        <td>{{ $reserva->mesa->identificador }}</td>
                                        <td>{{ $reserva->fecha }}</td>
                                        <td>{{ $reserva->hora }}</td>
                                        <td>{{ $reserva->num_personas }}</td>
                                        <td>{{ number_format($reserva->importe, 2) }} €</td>
                                        <td class="text-center">
                                            <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Cancelar Reserva"><i class="fas fa-times-circle"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    {{-- Si no hay reservas --}}
                                    @if ($restaurante->reservas->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">No hay reservas registradas aun en este restaurante.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Inicializar las pestañas de Bootstrap
        $(function () {
            $('#adminTabs a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            })
        })
    </script>
</body>
</html>