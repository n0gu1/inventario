<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de la Movimiento</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 30px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 10px; }
        .section { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .total { text-align: right; margin-top: 10px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="title">
        Detalle de la Movimiento #{{ $movement->serie }}-{{ str_pad($movement->correlative, 4, '0', STR_PAD_LEFT) }}
    </div>

    <div>
        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($movement->date)->format('d/m/Y H:i') }}<br>
        <strong>Tipo de movimiento:</strong> {{ $movement->type == 1 ? 'Ingreso' : 'Salida' }}<br>
        <strong>Almacen:</strong> {{ $movement->warehouse->name}}<br>
        <strong>Motivo:</strong> {{ $movement->reason->name}}<br>
        <strong>Observación:</strong> {{ $movement->observation ?? '_' }}
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movement->products as $i => $product)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>Q/ {{ number_format($product->pivot->price, 2) }}</td>
                        <td>Q/ {{ number_format($product->pivot->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total">
        <strong>Total: Q/ {{ number_format($movement->total, 2) }}</strong>
    </div>
</body>
</html>
