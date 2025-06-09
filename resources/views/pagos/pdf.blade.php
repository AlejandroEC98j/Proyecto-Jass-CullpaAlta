<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f8fafc; 
            padding: 20px; 
        }
        .container { 
            width: 100%; 
            max-width: 600px; 
            margin: auto; 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); 
            border: 1px solid #e2e8f0;
        }
        .header { 
            text-align: center; 
            padding-bottom: 15px; 
            margin-bottom: 20px;
            border-bottom: 2px solid #0e7490;
            position: relative;
        }
        .header h2 { 
            color: #0e7490; 
            margin: 0; 
            font-size: 24px;
            font-weight: 700;
        }
        .jass-info { 
            text-align: center; 
            font-size: 14px; 
            color: #64748b; 
            margin-top: 8px;
            font-weight: 500;
        }
        .logo-watermark {
            position: absolute;
            opacity: 0.1;
            font-size: 120px;
            font-weight: bold;
            color: #0e7490;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            pointer-events: none;
        }
        .details { 
            margin-top: 25px; 
            position: relative;
            z-index: 1;
        }
        .details p { 
            margin: 12px 0; 
            font-size: 16px; 
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 8px;
        }
        .details strong { 
            color: #334155; 
            font-weight: 600;
        }
        .footer { 
            text-align: center; 
            margin-top: 40px; 
            font-size: 13px; 
            color: #64748b;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        .highlight { 
            background: #0e7490; 
            color: white; 
            padding: 5px 10px; 
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }
        .amount {
            font-size: 18px;
            font-weight: 700;
            color: #0e7490;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-watermark">JASS CHAMBARA</div>
            <h2>COMPROBANTE DE PAGO</h2>
            <p class="jass-info">JASS CHAMBARA - Servicio de Agua Potable</p>
            <p class="jass-info">Concepción, Perú</p>
        </div>
        <div class="details">
            <p><strong>Cliente:</strong> <span>{{ $pago->factura->cliente->nombre }}</span></p>
            <p><strong>DNI:</strong> <span>{{ $pago->factura->cliente->dni }}</span></p>
            <p><strong>Factura N°:</strong> <span class="highlight">{{ $pago->factura->numero_factura }}</span></p>
            <p><strong>Monto Pagado:</strong> <span class="amount">{{ number_format($pago->monto_pagado, 2) }} PEN</span></p>
            <p><strong>Fecha de Pago:</strong> <span>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}</span></p>
            <p><strong>Método de Pago:</strong> <span>{{ $pago->metodo_pago ?? 'Efectivo' }}</span></p>
        </div>
        <div class="footer">
            <p>Gracias por su pago y confianza en nuestro servicio</p>
            <p><strong>JASS CHAMBARA</strong> - Comprometidos con la calidad del agua potable</p>
            <p style="margin-top: 15px; font-size: 11px;">Este comprobante es válido como documento de pago</p>
        </div>
    </div>
</body>
</html>