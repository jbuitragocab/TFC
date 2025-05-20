<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reservar en {{ $restaurante->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .booking-section {
            background: url('{{ asset('/img/res.jpg') }}') center center/cover no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .booking-box {
            background-color: #000000e6;
            border-radius: 30px;
            padding: 40px 30px;
            z-index: 2;
            text-align: center;
            width: 100%;
            max-width: 400px;
            color: white;
        }

        .booking-box h1 {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 2rem;
        }

        .booking-box p{
            margin-bottom: 20px;
        }


        .booking-box input[type="date"],
        .booking-box input[type="time"],
        .booking-box input[type="number"] {
            border-radius: 20px;
            padding: 10px 15px;
            margin-bottom: 15px;
            width: 100%;
            border: none;
        }

        .booking-box .btn-primary {
            background-color: #ff6a00;
            border: none;
            padding: 10px 30px;
            color: white;
            font-weight: bold;
            border-radius: 25px;
            width: 100%;
        }

        .booking-box .btn-primary:hover {
            background-color: #e55d00;
        }

        #mesas-disponibles-container {
            margin-top: 20px;
            text-align: left;
        }

        #mesas-disponibles-container h3{
            color: #fff;
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        #mesas-disponibles-container .list-group-item{
            background-color: #ffffff1a;
            border: 1px solid #ffffff33;
            color: #fff;
            border-radius: 10px;
            margin-bottom: 5px;
        }

        #mesas-disponibles-container .list-group-item input{
            margin-right: 10px;
        }

        #mesas-disponibles-container .btn-primary{
            margin-top: 15px;
            background-color: #ff6a00;
            border: none;
            padding: 10px 30px;
            color: white;
            font-weight: bold;
            border-radius: 25px;
        }

        #mesas-disponibles-container .btn-primary:hover {
            background-color: #e55d00;
        }

        .alert-warning{
            background-color: #ffc10733;
            border-color: #ffc10750;
            color: #fff;
            border-radius: 10px;
            padding: 15px;
        }
        .alert-danger {
            background-color: #dc354533;
            border-color: #dc354550;
            color: #fff;
            border-radius: 10px;
            padding: 15px;
        }

    </style>
</head>
<body>
    <div class="booking-section">
        <div class="overlay"></div>
        <div class="booking-box position-relative">
            <h1>Reservar en {{ $restaurante->nombre }}</h1>
            <p>Completa los detalles para encontrar mesas disponibles.</p>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form id="check-availability-form">
                @csrf
                <input type="hidden" name="restaurante_id" value="{{ $restaurante->id_restaurante }}">

                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required min="{{ date('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="hora">Hora:</label>
                    <input type="time" name="hora" id="hora" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="num_personas">Número de personas:</label>
                    <input type="number" name="num_personas" id="num_personas" class="form-control" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary">Buscar Mesas Disponibles</button>
            </form>

            <div id="mesas-disponibles-container" class="mt-4">
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#check-availability-form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let url = "{{ route('reservas.check_availability') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#mesas-disponibles-container').empty();
                        if (response.mesas && response.mesas.length > 0) {
                            let mesasHtml = '<h3>Mesas Disponibles para el ' + response.fecha + ' a las ' + response.hora + ':</h3>';
                            mesasHtml += '<form action="{{ route('reservas.store') }}" method="POST">';
                            mesasHtml += '@csrf';
                            mesasHtml += '<input type="hidden" name="restaurante_id" value="' + response.restaurante.id_restaurante + '">';
                            mesasHtml += '<input type="hidden" name="fecha" value="' + response.fecha + '">';
                            mesasHtml += '<input type="hidden" name="hora" value="' + response.hora + '">';
                            mesasHtml += '<input type="hidden" name="num_personas" value="' + response.num_personas + '">';
                            mesasHtml += '<div class="list-group">';

                            $.each(response.mesas, function(index, mesa) {
                                mesasHtml += `
                                    <label class="list-group-item">
                                        <input type="radio" name="mesa_id" value="${mesa.id}" required>
                                        Mesa ${mesa.identificador} (Capacidad: ${mesa.capacidad} personas)
                                    </label>
                                `;
                            });

                            mesasHtml += '</div>';
                            mesasHtml += '<button type="submit" class="btn btn-primary mt-3">Confirmar Reserva</button>';
                            mesasHtml += '</form>';
                            $('#mesas-disponibles-container').html(mesasHtml);
                            // Attach the form submission handler *here*, inside the availability check
                            $('#mesas-disponibles-container form').on('submit', function(e) {
                                e.preventDefault();
                                let reservationData = $(this).serialize();
                                let reservationUrl = "{{ route('reservas.store') }}";

                                $.ajax({
                                    url: reservationUrl,
                                    type: 'POST',
                                    data: reservationData,
                                    success: function(reservationResponse) {
                                        // Redirect to the user's reservations page
                                        window.location.href = "{{ route('reservas.show') }}";
                                    },
                                    error: function(xhr) {
                                        console.error("Error al crear la reserva:", xhr.responseText);
                                        let errorMessage = 'Hubo un error al crear la reserva.';
                                        if (xhr.responseJSON && xhr.responseJSON.message) {
                                            errorMessage = xhr.responseJSON.message;
                                            if (xhr.responseJSON.errors) {
                                                $.each(xhr.responseJSON.errors, function(key, value) {
                                                    errorMessage += '<br>' + value[0];
                                                });
                                            }
                                        }
                                        $('#mesas-disponibles-container').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                                    }
                                });
                            });

                        } else {
                            $('#mesas-disponibles-container').html('<div class="alert alert-warning">No hay mesas disponibles para la fecha, hora y número de personas seleccionados.</div>');
                        }
                    },
                    error: function(xhr) {
                        console.error("Error al buscar disponibilidad:", xhr.responseText);
                        let errorMessage = 'Hubo un error al buscar mesas disponibles.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                            if (xhr.responseJSON.errors) {
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    errorMessage += '<br>' + value[0];
                                });
                            }
                        }
                        $('#mesas-disponibles-container').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
