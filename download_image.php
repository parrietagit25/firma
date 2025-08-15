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
    <div style="background-color: white; padding: 20px; max-width: 600px; font-family: Arial, sans-serif;">
        <table style="border-collapse: collapse; width: 100%; height: 135px; color: #2c3e50; background-color: white;">
            <tbody>
                <tr>
                    <td style="width: 40%; height: 135px; vertical-align: top; padding: 10px;">
                        <p style="margin: 0 0 10px 0;">
                            <span style="font-size: 18px; color: #e74c3c; font-weight: bold;">' . htmlspecialchars($displayName) . '</span><br>
                            <strong style="color: #2c3e50; font-size: 14px;">' . htmlspecialchars($title) . '</strong>
                        </p>
                        <p style="margin: 0; font-size: 12px; color: #7f8c8d;">
                            ' . htmlspecialchars($email) . '<br>
                            ' . htmlspecialchars($phone) . '<br>
                            ' . htmlspecialchars($address) . '
                        </p>
                    </td>
                    <td style="width: 60%; height: 135px; text-align: center; vertical-align: middle; padding: 10px;">
                                                            <img src="img/1.png" alt="Logotipo1" width="350" height="181" style="display: block; max-width: 100%; height: auto;" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <img style="float: left;" src="img/2.png" alt="Logotipo2" width="612" height="107" />
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
