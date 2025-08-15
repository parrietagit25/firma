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
                background-color: white;
            }
            .signature-container {
                background-color: white;
                padding: 20px;
                max-width: 600px;
                margin: 0 auto;
            }
            .signature-table {
                border-collapse: collapse;
                width: 100%;
                height: 135px;
                color: #2c3e50;
                background-color: white;
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
                padding: 10px;
            }
            .name {
                font-size: 18px;
                color: #e74c3c;
                font-weight: bold;
                margin-bottom: 5px;
            }
            .title {
                color: #2c3e50;
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 10px;
            }
            .contact-details {
                font-size: 12px;
                color: #7f8c8d;
                line-height: 1.4;
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
                            <br>
                            <br>
                            <div class="name">' . htmlspecialchars($displayName) . '</div>
                            <div class="title">' . htmlspecialchars($title) . '</div>
                            <div class="contact-details">
                                ' . htmlspecialchars($email) . '<br>
                                ' . htmlspecialchars($phone) . '<br>
                                ' . htmlspecialchars($address) . '
                            </div>
                        </td>
                        <td class="logo-section">
                            <img src="img/1.png" alt="Logotipo1" width="350" height="181" style="display: block; max-width: 100%; height: auto;" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img src="img/2.png" alt="Logotipo2" width="612" height="107" style="display: block; max-width: 100%; height: auto;" />
                        </td>
                    </tr>
                </tbody>
            </table>
            
            
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
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
                <!--
                <button type="button" class="btn" onclick="copyToClipboard()">
                    📋 Copiar HTML
                </button>-->

                <button type="button" class="btn btn-secondary" onclick="downloadAsImage()">
                    📷 Descargar como imagen
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
            // Crear un contenedor temporal con el HTML de la firma
            const tempContainer = document.createElement('div');
            tempContainer.style.position = 'absolute';
            tempContainer.style.left = '-9999px';
            tempContainer.style.top = '-9999px';
            tempContainer.style.background = 'white';
            tempContainer.style.padding = '20px';
            tempContainer.style.width = '600px';
            tempContainer.style.height = '400px';
            tempContainer.style.overflow = 'hidden';
            
            // Insertar el HTML de la firma directamente
            tempContainer.innerHTML = `<?php echo addslashes($signatureHTML); ?>`;
            document.body.appendChild(tempContainer);

            // Mostrar indicador de carga
            const signaturePreview = document.querySelector('.signature-preview');
            const originalContent = signaturePreview.innerHTML;
            signaturePreview.innerHTML = '<div style="text-align: center; padding: 40px; color: #2c3e50;"><h3>🔄 Generando imagen...</h3><p>Por favor espera mientras se procesa la firma.</p></div>';

            // Esperar a que las imágenes se carguen completamente
            const images = tempContainer.querySelectorAll('img');
            let loadedImages = 0;
            const totalImages = images.length;

            if (totalImages === 0) {
                // No hay imágenes, proceder directamente
                generateImage();
            } else {
                // Esperar a que todas las imágenes se carguen
                images.forEach(img => {
                    if (img.complete && img.naturalHeight !== 0) {
                        loadedImages++;
                        if (loadedImages === totalImages) {
                            generateImage();
                        }
                    } else {
                        img.onload = () => {
                            loadedImages++;
                            if (loadedImages === totalImages) {
                                generateImage();
                            }
                        };
                        img.onerror = () => {
                            loadedImages++;
                            if (loadedImages === totalImages) {
                                generateImage();
                            }
                        };
                    }
                });
            }

            function generateImage() {
                // Usar html2canvas en el contenedor temporal
                html2canvas(tempContainer, {
                    backgroundColor: '#ffffff',
                    scale: 2, // Mejor calidad
                    useCORS: false, // No necesario para imágenes locales
                    allowTaint: false, // No necesario para imágenes locales
                    width: 600,
                    height: 400,
                    logging: false, // Desactivar logs
                    removeContainer: false, // No remover el contenedor
                    imageTimeout: 10000 // Timeout de 10 segundos
                }).then(canvas => {
                    // Restaurar contenido original
                    signaturePreview.innerHTML = originalContent;
                    
                    // Crear enlace de descarga
                    const link = document.createElement('a');
                    link.download = 'firma_<?php echo addslashes($displayName); ?>.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                    
                    // Limpiar
                    document.body.removeChild(tempContainer);
                    
                    // Mostrar mensaje de éxito
                    alert('✅ Imagen descargada exitosamente como "firma_<?php echo addslashes($displayName); ?>.png"');
                }).catch(error => {
                    console.error('Error al generar imagen:', error);
                    
                    // Restaurar contenido original
                    signaturePreview.innerHTML = originalContent;
                    
                    // Limpiar
                    document.body.removeChild(tempContainer);
                    
                    alert('❌ Error al generar la imagen. Por favor, usa la descarga HTML.\n\nError: ' + error.message);
                });
            }
        }
    </script>
</body>
</html>
