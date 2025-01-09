<form method="POST" action="{{ $action }}">
    @csrf
    <div class="form-group">
        <label for="monto">Monto del Pago</label>
        <input type="number" name="monto" id="monto" class="form-control" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-primary">Registrar Pago</button>
</form>