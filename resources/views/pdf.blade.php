<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Electrónica</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 30px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-info, .client-info {
            width: 100%;
            margin-bottom: 30px;
        }
        .company-info td, .client-info td {
            vertical-align: top;
        }
        .invoice-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-details th, .invoice-details td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .totals {
            float: right;
            width: 40%;
            border-collapse: collapse;
        }
        .totals th, .totals td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pedido</h2>
        <p>PPP1-0001</p>
    </div>

    <table class="company-info">
        <tr>
            <td>
                <strong>Empresa:</strong><br>
                {{ $nombre }}<br>
                {{ $direccion }}<br>
                RUC: 20607026719
            </td>
            <td style="text-align:right;">
                <strong>Cliente:</strong><br>
                {{ $nombre }}<br>
                {{ $direccion }}<br>
                DNI/RUC: 70539890
            </td>
        </tr>
    </table>

    <table class="invoice-details">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach(Cart::content() as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>S/ {{ number_format($item->price, 2) }}</td>
                <td>S/ {{ number_format($item->price * $item->qty, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <th>Subtotal</th>
            <td>S/ {{ number_format(Cart::subtotal()/1.18, 2) }}</td>
        </tr>
        <tr>
            <th>IGV (18%)</th>
            <td>S/ {{ number_format(Cart::subtotal() - Cart::subtotal()/1.18, 2) }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <td><strong>S/ {{ number_format(Cart::subtotal(), 2) }}</strong></td>
        </tr>
    </table>

    <div class="footer">
        <p>Gracias por su compra.</p>
    </div>
</body>
</html>
