<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Reserva en {{ $reserva->restaurante->nombre ?? 'Restaurante' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
                        background: url('{{ asset('/img/res.jpg') }}') center center/cover no-repeat;
            color: #fff;
            padding-top: 50px;
            text-align: center;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .edit-box {
            background-color: #000000e6;
            border-radius: 30px;
            padding: 40px 30px;
            z-index: 2;
            text-align: left; /* Alineado a la izquierda para los campos */
            width: 100%;
            max-width: 500px; /* Ancho máximo para el formulario */
            color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        h2 {
            font-weight: bold;
            margin-bottom: 30px;
            font-size: 2rem;
            text-align: center;
            color: #ff6a00; /* Color naranja para el título */
        }

        .form-label {
            font-weight: bold;
            color: #ccc;
            margin-bottom: 5px;
        }

        .form-control, .form-select {
            border-radius: 20px;
            padding: 10px 15px;
            margin-bottom: 15px;
            width: 100%;
            border: none;
            background-color: #333; /* Fondo oscuro para inputs */
            color: #fff;
        }

        .form-control:focus, .form-select:focus {
            background-color: #444;
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(255, 106, 0, 0.25); /* Sombra de enfoque naranja */
        }

        .btn-primary, .btn-secondary {
            background-color: #ff6a00;
            border: none;
            padding: 10px 30px;
            color: white;
            font-weight: bold;
            border-radius: 25px;
            width: auto; /* Ancho automático para los botones */
            margin-right: 10px; /* Espacio entre botones */
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #e55d00;
        }

        .btn-secondary {
            background-color: #6c757d; /* Color gris para cancelar */
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        #mesas-disponibles-container {
            margin-top: 20px;
            text-align: left;
            width: 100%;
        }

        #mesas-disponibles-container h3 {
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        #mesas-disponibles-container .list-group-item {
            background-color: #ffffff1a;
            border: 1px solid #ffffff33;
            color: #fff;
            border-radius: 10px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        #mesas-disponibles-container .list-group-item input[type="radio"] {
            margin-right: 10px;
            width: auto;
            margin-bottom: 0; /* Eliminar margen inferior del input radio */
        }

        .alert {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.3);
            border-color: rgba(220, 53, 69, 0.5);
            color: #dc3545;
        }

        .alert-warning {
            background-color: rgba(255, 193, 7, 0.3);
            border-color: rgba(255, 193, 7, 0.5);
            color: #ffc107;
        }

        .btn-orange {
            background-color: #ff6a00;
            border: none;
            color: white;
            padding: 8px 20px;
            font-weight: bold;
            border-radius: 25px;
            font-style: italic;
        }

        .btn-orange:hover {
            background-color: #ffa600;
            color: white;
        }

        footer {
            text-align: center;
            color: white;
            padding: 15px;
            font-size: 0.85rem;
            background-color: rgba(0, 0, 0, 0.8);
            margin-top: auto;
        }
    </style>
</head>
<body class="d-flex flex-column">


    <div class="container">
        <div class="edit-box">
            <h2 style="color:white;">Edita tu reserva</h2>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('reservas.update', $reserva->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Campo oculto para el ID del restaurante (no editable) --}}
                <input type="hidden" name="restaurante_id" value="{{ $reserva->restaurante_id }}">

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $reserva->fecha }}" required >
                </div>

                <div class="mb-3">
                    <label for="hora" class="form-label">Hora</label>
                    <input type="time" name="hora" id="hora" class="form-control" value="{{ \Carbon\Carbon::parse($reserva->hora)->format('H:i') }}" required>
                </div>

                <div class="mb-3">
                    <label for="num_personas" class="form-label">Número de Personas</label>
                    <input type="number" name="num_personas" id="num_personas" class="form-control" value="{{ $reserva->num_personas }}" min="1" required>
                </div>

                <div class="mb-3">
                    <label for="mesa_id" class="form-label">Mesa</label>
                    <select name="mesa_id" id="mesa_id" class="form-control" required>
                        {{-- Las opciones se cargarán dinámicamente con JavaScript --}}
                        <option value="{{ $reserva->mesa_id }}" selected>
                            Mesa #{{ $reserva->mesa->identificador ?? $reserva->mesa_id }} (Capacidad: {{ $reserva->mesa->capacidad ?? 'N/A' }})
                        </option>
                    </select>
                    <div id="mesa-availability-message" class="text-white mt-2" style="font-size: 0.9rem;"></div>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
                <a href="{{ route('reservas.show') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para cargar mesas disponibles
            function loadAvailableTables() {
                const restauranteId = $('input[name="restaurante_id"]').val();
                const fecha = $('#fecha').val();
                const hora = $('#hora').val();
                const numPersonas = $('#num_personas').val();
                const currentMesaId = {{ $reserva->mesa_id }}; // ID de la mesa actual de la reserva

                if (!fecha || !hora || !numPersonas || !restauranteId) {
                    $('#mesa_id').html('<option value="">Selecciona fecha, hora y número de personas</option>');
                    $('#mesa-availability-message').text('');
                    return;
                }

                $.ajax({
                    url: "{{ route('reservas.check_availability') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        restaurante_id: restauranteId,
                        fecha: fecha,
                        hora: hora,
                        num_personas: numPersonas
                    },
                    success: function(response) {
                        let options = '';
                        let mesaEncontrada = false;
                        let mesaActualDisponible = false;

                        if (response.mesas && response.mesas.length > 0) {
                            $.each(response.mesas, function(index, mesa) {
                                const isSelected = (mesa.id == currentMesaId) ? 'selected' : '';
                                if (mesa.id == currentMesaId) {
                                    mesaActualDisponible = true;
                                }
                                options += `<option value="${mesa.id}" ${isSelected}>Mesa #${mesa.identificador} (Capacidad: ${mesa.capacidad} personas)</option>`;
                            });
                            $('#mesa-availability-message').text('');
                        } else {
                            options = '<option value="">No hay mesas disponibles para estos criterios</option>';
                            $('#mesa-availability-message').text('No hay mesas disponibles para los criterios seleccionados.');
                        }
                        $('#mesa_id').html(options);

                        // Si la mesa actual no está en la lista de disponibles, añadirla como opción deshabilitada
                        if (!mesaActualDisponible && currentMesaId) {
                             const currentMesaIdentifier = '{{ $reserva->mesa->identificador ?? $reserva->mesa_id }}';
                             const currentMesaCapacidad = '{{ $reserva->mesa->capacidad ?? 'N/A' }}';
                             const currentMesaOption = `<option value="${currentMesaId}" selected disabled>Mesa #${currentMesaIdentifier} (Capacidad: ${currentMesaCapacidad} personas) - No disponible</option>`;
                             $('#mesa_id').prepend(currentMesaOption);
                             $('#mesa-availability-message').text('Tu mesa actual no está disponible para los nuevos criterios. Por favor, selecciona otra.');
                        }
                    },
                    error: function(xhr) {
                        console.error("Error al buscar disponibilidad:", xhr.responseText);
                        $('#mesa_id').html('<option value="">Error al cargar mesas</option>');
                        $('#mesa-availability-message').text('Error al cargar mesas disponibles.');
                    }
                });
            }

            // Cargar mesas al iniciar la página
            loadAvailableTables();

            // Cargar mesas cuando cambian los campos relevantes
            $('#fecha, #hora, #num_personas').on('change', loadAvailableTables);
        });
    </script>
</body>
</html>
