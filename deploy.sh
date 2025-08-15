#!/bin/bash

echo "🚀 Desplegando Generador de Firmas..."

# Verificar si Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "❌ Docker no está instalado. Por favor, instala Docker primero."
    exit 1
fi

# Verificar si Docker Compose está instalado
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose no está instalado. Por favor, instala Docker Compose primero."
    exit 1
fi

# Crear directorios necesarios
echo "📁 Creando directorios..."
mkdir -p logs/nginx
mkdir -p img

# Verificar si existe la red de Docker
if ! docker network ls | grep -q "nps_nps_network"; then
    echo "❌ La red 'nps_nps_network' no existe. Por favor, asegúrate de que los contenedores NPS estén ejecutándose."
    exit 1
fi

# Detener contenedores existentes si los hay
echo "🛑 Deteniendo contenedores existentes..."
docker-compose down

# Construir y levantar los contenedores
echo "🔨 Construyendo contenedores..."
docker-compose up --build -d

# Esperar a que los contenedores estén listos
echo "⏳ Esperando a que los contenedores estén listos..."
sleep 10

# Verificar el estado de los contenedores
echo "🔍 Verificando estado de los contenedores..."
docker-compose ps

# Verificar logs
echo "📋 Mostrando logs del generador de firmas..."
docker-compose logs generador-firmas

echo ""
echo "✅ Despliegue completado!"
echo ""
echo "🌐 El generador de firmas estará disponible en:"
echo "   http://54.94.232.102:8084"
echo ""
echo "📊 Para ver los logs en tiempo real:"
echo "   docker-compose logs -f generador-firmas"
echo ""
echo "🛑 Para detener los servicios:"
echo "   docker-compose down"
echo ""
echo "🔄 Para reiniciar los servicios:"
echo "   docker-compose restart"
