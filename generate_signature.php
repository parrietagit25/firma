<?php
// Configuración de headers para evitar caché
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

// Obtener y validar los datos del formulario
$displayName = trim($_POST['displayName'] ?? '');
$title = trim($_POST['title'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');

// Validar que todos los campos estén completos
if (empty($displayName) || empty($title) || empty($email) || empty($phone) || empty($address)) {
    die('Error: Todos los campos son obligatorios.');
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Error: Formato de email inválido.');
}

// Función para generar el HTML de la firma
function generateSignatureHTML($displayName, $title, $email, $phone, $address) {
    return '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Firma de Correo - ' . htmlspecialchars($displayName) . '</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: #2c3e50;
            }
            .signature-container {
                background-color: #2c3e50;
                padding: 20px;
                max-width: 600px;
                margin: 0 auto;
            }
            .signature-table {
                border-collapse: collapse;
                width: 100%;
                height: 135px;
                color: white;
            }
            .signature-table td {
                vertical-align: top;
                padding: 10px;
            }
            .contact-info {
                width: 40%;
            }
            .logo-section {
                width: 60%;
                text-align: center;
                vertical-align: middle;
            }
            .name {
                font-size: 18px;
                color: #e74c3c;
                font-weight: bold;
                margin-bottom: 5px;
            }
            .title {
                color: #ecf0f1;
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 10px;
            }
            .contact-details {
                font-size: 12px;
                color: #bdc3c7;
                line-height: 1.4;
            }
            .company-logo {
                background: white;
                padding: 15px;
                border-radius: 8px;
                display: inline-block;
            }
            .company-name {
                color: #2c3e50;
                font-size: 24px;
                font-weight: bold;
            }
            .company-tagline {
                color: #7f8c8d;
                font-size: 12px;
                text-transform: uppercase;
            }
            .services-section {
                background: white;
                padding: 15px;
                border-radius: 8px;
                margin-top: 15px;
                text-align: center;
            }
            .services-grid {
                display: flex;
                justify-content: space-around;
                align-items: center;
                flex-wrap: wrap;
                gap: 20px;
            }
            .service-item {
                text-align: center;
            }
            .service-name {
                color: #2c3e50;
                font-weight: bold;
                font-size: 14px;
            }
            .service-type {
                color: #e74c3c;
                font-size: 12px;
            }
            .certification-section {
                background: white;
                padding: 15px;
                border-radius: 8px;
                margin-top: 15px;
            }
            .certification-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .iso-badge {
                background: #e74c3c;
                color: white;
                padding: 10px;
                border-radius: 5px;
                text-align: center;
            }
            .iso-number {
                font-weight: bold;
            }
            .iso-company {
                font-size: 12px;
            }
            .commitment-text {
                color: #2c3e50;
                font-style: italic;
                text-align: right;
                max-width: 60%;
            }
            @media print {
                body { background-color: white !important; }
                .signature-container { background-color: white !important; }
            }
        </style>
    </head>
    <body>
        <div class="signature-container">
            <table class="signature-table">
                <tbody>
                    <tr>
                        <td class="contact-info">
                            <div class="name">' . htmlspecialchars($displayName) . '</div>
                            <div class="title">' . htmlspecialchars($title) . '</div>
                            <div class="contact-details">
                                ' . htmlspecialchars($email) . '<br>
                                ' . htmlspecialchars($phone) . '<br>
                                ' . htmlspecialchars($address) . '
                            </div>
                        </td>
                        <td class="logo-section">
                            <div class="company-logo">
                                <div class="company-name">GrupoPCR</div>
                                <div class="company-tagline">PANAMA CAR RENTAL</div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="services-section">
                <div class="services-grid">
                    <div class="service-item">
                        <div class="service-name">AUTOMARKET</div>
                        <div class="service-type">RENT A CAR ✓</div>
                    </div>
                    <div class="service-item">
                        <div class="service-name">AUTOSERVICE</div>
                        <div class="service-type">TALLER ✓</div>
                    </div>
                    <div class="service-item">
                        <div class="service-name">PANARENTING</div>
                        <div class="service-type">RENTING</div>
                    </div>
                    <div class="service-item">
                        <div class="service-name">AUTOMARKET</div>
                        <div class="service-type">SEMINUEVOS ✓</div>
                    </div>
                </div>
            </div>
            
            <div class="certification-section">
                <div class="certification-content">
                    <div class="iso-badge">
                        <div class="iso-number">ISO 45001:2018</div>
                        <div class="iso-company">BUREAU VERITAS</div>
                    </div>
                    <div class="commitment-text">
                        Comprometidos con la seguridad de nuestros colaboradores, clientes y proveedores.
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>';
}

// Generar la firma
$signatureHTML = generateSignatureHTML($displayName, $title, $email, $phone, $address);

// Crear nombre de archivo para descarga
$filename = 'firma_' . preg_replace('/[^a-zA-Z0-9]/', '_', $displayName) . '.html';

// Si se solicita descarga directa
if (isset($_POST['download']) && $_POST['download'] === 'true') {
    header('Content-Type: text/html; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo $signatureHTML;
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firma Generada - GrupoPCR</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .content-section {
            padding: 40px;
        }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .signature-preview {
            background: #2c3e50;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            overflow: hidden;
        }

        .download-options {
            text-align: center;
            margin: 30px 0;
        }

        .btn {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 10px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
        }

        .btn-secondary:hover {
            box-shadow: 0 10px 20px rgba(149, 165, 166, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        }

        .btn-success:hover {
            box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);
        }

        .back-link {
            text-align: center;
            margin-top: 30px;
        }

        .back-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }
            
            .content-section {
                padding: 20px;
            }
            
            .btn {
                display: block;
                margin: 10px auto;
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Firma Generada Exitosamente</h1>
            <p>Tu firma de correo está lista para usar</p>
        </div>

        <div class="content-section">
            <div class="success-message">
                <h3>¡Perfecto! La firma para <strong><?php echo htmlspecialchars($displayName); ?></strong> ha sido generada.</h3>
                <p>Puedes descargarla como archivo HTML o copiarla directamente a tu cliente de correo.</p>
            </div>

            <div class="signature-preview">
                <?php echo $signatureHTML; ?>
            </div>

            <div class="download-options">
                <h3 style="margin-bottom: 20px; color: #2c3e50;">📥 Opciones de Descarga</h3>
                
                <form method="POST" action="generate_signature.php" style="display: inline;">
                    <input type="hidden" name="displayName" value="<?php echo htmlspecialchars($displayName); ?>">
                    <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                    <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">
                    <input type="hidden" name="download" value="true">
                    <button type="submit" class="btn btn-success">
                        💾 Descargar HTML
                    </button>
                </form>

                <button type="button" class="btn" onclick="copyToClipboard()">
                    📋 Copiar HTML
                </button>

                <button type="button" class="btn btn-secondary" onclick="downloadAsImage()">
                    📷 Descargar como Imagen
                </button>
            </div>

            <div class="back-link">
                <a href="index.html">← Volver al Generador</a>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const signatureHTML = `<?php echo addslashes($signatureHTML); ?>`;
            
            navigator.clipboard.writeText(signatureHTML).then(function() {
                alert('✅ HTML copiado al portapapeles. Ahora puedes pegarlo en tu cliente de correo.');
            }).catch(function(err) {
                console.error('Error al copiar: ', err);
                alert('Error al copiar. Por favor, usa la descarga HTML.');
            });
        }

        function downloadAsImage() {
            // Implementar descarga como imagen usando html2canvas
            alert('Función de descarga como imagen en desarrollo. Por ahora usa la descarga HTML o copia el código.');
        }
    </script>
</body>
</html>
