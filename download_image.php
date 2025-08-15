<?php
// Archivo para manejar la descarga de la firma como imagen
// Este archivo se puede usar en conjunto con html2canvas en el frontend

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
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
    http_response_code(400);
    echo json_encode(['error' => 'Todos los campos son obligatorios']);
    exit;
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Formato de email inválido']);
    exit;
}

// Función para generar el HTML de la firma (versión simplificada para imagen)
function generateSignatureHTMLForImage($displayName, $title, $email, $phone, $address) {
    return '
    <div style="background-color: #2c3e50; padding: 20px; max-width: 600px; font-family: Arial, sans-serif;">
        <table style="border-collapse: collapse; width: 100%; height: 135px; color: white;">
            <tbody>
                <tr>
                    <td style="width: 40%; height: 135px; vertical-align: top; padding: 10px;">
                        <p style="margin: 0 0 10px 0;">
                            <span style="font-size: 18px; color: #e74c3c; font-weight: bold;">' . htmlspecialchars($displayName) . '</span><br>
                            <strong style="color: #ecf0f1; font-size: 14px;">' . htmlspecialchars($title) . '</strong>
                        </p>
                        <p style="margin: 0; font-size: 12px; color: #bdc3c7;">
                            ' . htmlspecialchars($email) . '<br>
                            ' . htmlspecialchars($phone) . '<br>
                            ' . htmlspecialchars($address) . '
                        </p>
                    </td>
                    <td style="width: 60%; height: 135px; text-align: center; vertical-align: middle;">
                        <div style="background: white; padding: 15px; border-radius: 8px; display: inline-block;">
                            <div style="color: #2c3e50; font-size: 24px; font-weight: bold;">GrupoPCR</div>
                            <div style="color: #7f8c8d; font-size: 12px; text-transform: uppercase;">PANAMA CAR RENTAL</div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div style="background: white; padding: 15px; border-radius: 8px; margin-top: 15px; text-align: center;">
            <div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div style="text-align: center;">
                    <div style="color: #2c3e50; font-weight: bold; font-size: 14px;">AUTOMARKET</div>
                    <div style="color: #e74c3c; font-size: 12px;">RENT A CAR ✓</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: #2c3e50; font-weight: bold; font-size: 14px;">AUTOSERVICE</div>
                    <div style="color: #e74c3c; font-size: 12px;">TALLER ✓</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: #2c3e50; font-weight: bold; font-size: 14px;">PANARENTING</div>
                    <div style="color: #e74c3c; font-size: 12px;">RENTING</div>
                </div>
                <div style="text-align: center;">
                    <div style="color: #2c3e50; font-weight: bold; font-size: 14px;">AUTOMARKET</div>
                    <div style="color: #e74c3c; font-size: 12px;">SEMINUEVOS ✓</div>
                </div>
            </div>
        </div>
        
        <div style="background: white; padding: 15px; border-radius: 8px; margin-top: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="background: #e74c3c; color: white; padding: 10px; border-radius: 5px; text-align: center;">
                    <div style="font-weight: bold;">ISO 45001:2018</div>
                    <div style="font-size: 12px;">BUREAU VERITAS</div>
                </div>
                <div style="color: #2c3e50; font-style: italic; text-align: right; max-width: 60%;">
                    Comprometidos con la seguridad de nuestros colaboradores, clientes y proveedores.
                </div>
            </div>
        </div>
    </div>';
}

// Generar la firma
$signatureHTML = generateSignatureHTMLForImage($displayName, $title, $email, $phone, $address);

// Crear nombre de archivo para descarga
$filename = 'firma_' . preg_replace('/[^a-zA-Z0-9]/', '_', $displayName) . '.html';

// Devolver respuesta JSON con el HTML generado
echo json_encode([
    'success' => true,
    'html' => $signatureHTML,
    'filename' => $filename,
    'message' => 'Firma generada exitosamente'
]);
?>
