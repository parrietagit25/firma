# 🚀 Despliegue del Generador de Firmas en Docker

## 📋 Requisitos Previos

- Docker instalado y funcionando
- Docker Compose instalado
- Puerto 8084 disponible en el servidor
- Red Docker `nps_nps_network` existente

## 🏗️ Estructura del Proyecto

```
firma/
├── Dockerfile                 # Imagen Docker para PHP
├── docker-compose.yml         # Orquestación de servicios
├── apache.conf                # Configuración personalizada de Apache
├── nginx-proxy-config.conf    # Configuración para proxy reverso (opcional)
├── .dockerignore             # Archivos excluidos del build
├── deploy.sh                 # Script de despliegue automático
├── index.html                # Formulario principal
├── generate_signature.php    # Generación de firmas
├── download_image.php        # API para descarga
├── img/                      # Carpeta de imágenes
│   ├── 1.png               # Logo principal
│   └── 2.png               # Banner de servicios
└── README_DEPLOY.md         # Este archivo
```

## 🚀 Despliegue Automático

### Opción 1: Script Automático (Recomendado)

```bash
# Hacer ejecutable el script
chmod +x deploy.sh

# Ejecutar el despliegue
./deploy.sh
```

### Opción 2: Comandos Manuales

```bash
# 1. Crear directorios necesarios
mkdir -p logs
mkdir -p img

# 2. Construir y levantar contenedores
docker-compose up --build -d

# 3. Verificar estado
docker-compose ps

# 4. Ver logs
docker-compose logs generador-firmas
```

## 🌐 Acceso a la Aplicación

### Acceso Directo (Recomendado para pruebas)
**URL:** `http://54.94.232.102:8084`

### Acceso a través de Proxy Reverso (Opcional)
Si quieres acceder a través de la ruta `/generador_firmas`, puedes:

1. **Agregar la configuración de Nginx** del archivo `nginx-proxy-config.conf` a tu servidor Nginx existente
2. **Reiniciar Nginx** después de la configuración
3. **Acceder a:** `http://54.94.232.102/generador_firmas`

## 🔧 Configuración de Redes

El proyecto se integra con tu infraestructura existente:

- **Red:** `nps_nps_network` (compartida con NPS)
- **Puerto:** 8084 (interno del contenedor)
- **Servidor Web:** Apache con configuración personalizada

## 📊 Gestión de Contenedores

### Ver Estado
```bash
docker-compose ps
```

### Ver Logs
```bash
# Logs del generador de firmas
docker-compose logs generador-firmas

# Logs en tiempo real
docker-compose logs -f generador-firmas
```

### Reiniciar Servicios
```bash
# Reiniciar todo
docker-compose restart

# Reiniciar servicio específico
docker-compose restart generador-firmas
```

### Detener Servicios
```bash
docker-compose down
```

### Actualizar Aplicación
```bash
# Reconstruir y reiniciar
docker-compose up --build -d
```

## 🐛 Solución de Problemas

### Error: Red no encontrada
```bash
# Verificar redes disponibles
docker network ls

# Si nps_nps_network no existe, verificar que los contenedores NPS estén ejecutándose
docker ps | grep nps
```

### Error: Puerto ocupado
```bash
# Verificar puertos en uso
netstat -tulpn | grep :8084

# Cambiar puerto en docker-compose.yml
ports:
  - "8085:80"  # Cambiar 8084 por 8085
```

### Error: Permisos de archivos
```bash
# Corregir permisos
sudo chown -R $USER:$USER .
chmod -R 755 img/
```

### Error: Imágenes no se cargan
```bash
# Verificar que las imágenes estén en la carpeta img/
ls -la img/

# Verificar logs del contenedor
docker-compose logs generador-firmas
```

## 🔒 Seguridad

- **Puerto interno:** Solo accesible a través del puerto 8084
- **CORS:** Configurado para permitir acceso desde cualquier origen
- **Permisos:** Archivos con permisos mínimos necesarios
- **Logs:** Registro de acceso y errores habilitado

## 📈 Monitoreo

### Métricas del Contenedor
```bash
# Uso de recursos
docker stats generador-firmas

# Información detallada
docker inspect generador-firmas
```

### Logs del Sistema
```bash
# Logs de Apache
docker exec generador-firmas tail -f /var/log/apache2/access.log
```

## 🔄 Actualizaciones

### Actualizar Código
```bash
# 1. Hacer pull del código actualizado
git pull origin main

# 2. Reconstruir contenedores
docker-compose up --build -d

# 3. Verificar logs
docker-compose logs generador-firmas
```

### Actualizar Imágenes
```bash
# 1. Reemplazar archivos en img/
# 2. Reiniciar contenedor
docker-compose restart generador-firmas
```

## 📞 Soporte

Para problemas técnicos o consultas:

- **Revisar logs:** `docker-compose logs generador-firmas`
- **Verificar estado:** `docker-compose ps`
- **Reiniciar servicios:** `docker-compose restart`

## ✅ Verificación del Despliegue

1. **Contenedores ejecutándose:**
   ```bash
   docker-compose ps
   ```

2. **Acceso a la aplicación:**
   - Abrir `http://54.94.232.102:8084`
   - Verificar que se muestre el formulario

3. **Funcionalidad:**
   - Llenar formulario de prueba
   - Generar firma
   - Descargar HTML
   - Descargar PNG

4. **Logs sin errores:**
   ```bash
   docker-compose logs generador-firmas | grep -i error
   ```

## 🌐 Configuración de Proxy Reverso (Opcional)

Si quieres acceder a través de la ruta `/generador_firmas`:

1. **Editar tu configuración de Nginx** (generalmente en `/etc/nginx/sites-available/default`)
2. **Agregar el contenido** del archivo `nginx-proxy-config.conf`
3. **Reiniciar Nginx:**
   ```bash
   sudo systemctl reload nginx
   # o
   sudo nginx -s reload
   ```

---

**🎯 El generador de firmas estará completamente funcional en Docker y accesible en el puerto 8084.**
