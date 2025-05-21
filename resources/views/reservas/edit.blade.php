{{-- filepath: resources/views/reservas/edit.blade.php --}}
<div class="container">
    <h2>Editar Reserva</h2>
    <form action="{{ route('reservas.update', $reserva->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="restaurante_id" class="form-label">Restaurante</label>
            <select name="restaurante_id" id="restaurante_id" class="form-control" required>
                @foreach($restaurantes as $restaurante)
                    <option value="{{ $restaurante->id_restaurante }}" {{ $reserva->restaurante_id == $restaurante->id_restaurante ? 'selected' : '' }}>
                        {{ $restaurante->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="mesa_id" class="form-label">Mesa</label>
            <select name="mesa_id" id="mesa_id" class="form-control" required>
                @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}" {{ $reserva->mesa_id == $mesa->id ? 'selected' : '' }}>
                        Mesa #{{ $mesa->id }} (Capacidad: {{ $mesa->capacidad }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $reserva->fecha }}" required>
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" name="hora" id="hora" class="form-control" value="{{ $reserva->hora }}" required>
        </div>

        <div class="mb-3">
            <label for="num_personas" class="form-label">Número de Personas</label>
            <input type="number" name="num_personas" id="num_personas" class="form-control" value="{{ $reserva->num_personas }}" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
        <a href="{{ route('reservas.show') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>