# 🏢 Generador de Firmas de Correo - GrupoPCR

Sistema completo para generar firmas de correo electrónico profesionales personalizadas para empleados de GrupoPCR.

## ✨ Características

- **Formulario intuitivo** para capturar datos del empleado
- **Vista previa en tiempo real** de la firma generada
- **Diseño profesional** basado en la imagen de referencia
- **Múltiples opciones de descarga**:
  - 📄 Archivo HTML completo
  - 📋 Código HTML para copiar/pegar
  - 📷 Imagen PNG
- **Validación de datos** completa
- **Diseño responsivo** para todos los dispositivos
- **Estilo corporativo** de GrupoPCR

## 🚀 Instalación y Uso

### Requisitos
- Servidor web con soporte PHP 7.4+
- Navegador web moderno
- XAMPP, WAMP, o similar para desarrollo local

### Instalación
1. Coloca todos los archivos en tu directorio web
2. Asegúrate de que PHP esté habilitado
3. Accede a `index.html` desde tu navegador

### Uso del Sistema

#### 1. Llenar el Formulario
- **Nombre Completo**: Nombre completo del empleado
- **Puesto/Cargo**: Título o posición en la empresa
- **Correo Electrónico**: Email corporativo
- **Número de Teléfono**: Teléfono de contacto
- **Dirección**: Dirección física de la empresa

#### 2. Vista Previa
- Haz clic en "👁️ Vista Previa" para ver cómo se verá la firma
- Revisa que todos los datos estén correctos

#### 3. Generar Firma
- Haz clic en "🚀 Generar Firma" para procesar
- El sistema generará la firma completa

#### 4. Descargar o Copiar
- **💾 Descargar HTML**: Descarga un archivo HTML completo
- **📋 Copiar HTML**: Copia el código al portapapeles
- **📷 Descargar como Imagen**: Genera una imagen PNG (en desarrollo)

## 📁 Estructura de Archivos

```
firma/
├── index.html              # Formulario principal
├── generate_signature.php  # Procesamiento y generación de firmas
├── download_image.php      # API para descarga de imágenes
└── README.md              # Este archivo
```

## 🎨 Diseño de la Firma

La firma generada incluye:

### Sección Superior
- **Información del empleado**: Nombre, cargo, email, teléfono, dirección
- **Logo corporativo**: Imagen oficial de GrupoPCR desde AWS S3

### Sección Inferior
- **Banner de servicios**: Imagen oficial con todos los servicios de la empresa desde AWS S3

## 🔧 Personalización

### Colores Corporativos
- **Fondo principal**: `#ffffff` (Blanco)
- **Acentos**: `#e74c3c` (Rojo)
- **Texto principal**: `#2c3e50` (Gris oscuro)
- **Texto secundario**: `#7f8c8d` (Gris medio)

### Fuentes
- **Principal**: Arial, sans-serif
- **Interfaz**: Segoe UI, Tahoma, Geneva, Verdana, sans-serif

## 📱 Responsividad

El sistema está optimizado para:
- **Desktop**: Pantallas grandes con layout de dos columnas
- **Tablet**: Layout adaptativo con elementos reorganizados
- **Mobile**: Diseño de una columna para pantallas pequeñas

## 🛡️ Seguridad

- **Validación de entrada**: Todos los campos son validados
- **Sanitización HTML**: Prevención de XSS
- **Validación de email**: Formato correcto requerido
- **Headers de seguridad**: Prevención de caché y redirecciones

## 🚧 Funcionalidades en Desarrollo

- **Descarga como imagen PNG**: ✅ Implementado usando html2canvas
- **Editor visual**: Para personalizar colores y estilos
- **Plantillas adicionales**: Diferentes estilos de firma
- **Base de datos**: Para guardar firmas generadas

## 🔍 Solución de Problemas

### Error de Validación
- Asegúrate de que todos los campos estén completos
- Verifica que el email tenga formato válido

### Problemas de Descarga
- Verifica permisos de escritura en el servidor
- Asegúrate de que PHP esté habilitado

### Vista Previa no Funciona
- Verifica que JavaScript esté habilitado
- Revisa la consola del navegador para errores

## 📞 Soporte

Para soporte técnico o personalizaciones adicionales:
- **Empresa**: GrupoPCR
- **Departamento**: Tecnología
- **Email**: luis.hernandez@grupopcr.com.pa

## 📄 Licencia

Este sistema es propiedad de GrupoPCR y está diseñado para uso interno de la empresa.

---

**Desarrollado con ❤️ para GrupoPCR**
*Sistema de Generación de Firmas de Correo Electrónico*
