#!/bin/bash
set -e

echo "============================================"
echo "  Iniciando aplicación Laravel..."
echo "============================================"

# Esperar a que MySQL esté listo
echo "[1/7] Esperando conexión a MySQL..."
max_retries=30
counter=0
until php -r "try { new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); echo 'ok'; } catch(Exception \$e) { exit(1); }" 2>/dev/null || [ $counter -eq $max_retries ]; do
    counter=$((counter + 1))
    echo "  Intento $counter/$max_retries - MySQL no disponible, esperando 5s..."
    sleep 5
done

if [ $counter -eq $max_retries ]; then
    echo "ERROR: No se pudo conectar a MySQL después de $max_retries intentos"
    exit 1
fi
echo "  MySQL conectado correctamente."

# Crear directorios de almacenamiento necesarios
echo "[2/7] Preparando directorios de almacenamiento..."
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/storage/app/backups
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Permisos
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Generar APP_KEY si no existe
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "[3/7] Generando APP_KEY..."
    php artisan key:generate --force
else
    echo "[3/7] APP_KEY ya configurada."
fi

# Cache de configuración
echo "[4/7] Cacheando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
echo "[5/7] Ejecutando migraciones de base de datos..."
php artisan migrate --force

# Crear enlace simbólico de storage
echo "[6/7] Creando enlace simbólico de storage..."
php artisan storage:link --force 2>/dev/null || true

# Log de inicio
echo "[7/7] Creando log de inicio..."
touch /var/log/cron.log
chown www-data:www-data /var/log/cron.log

echo "============================================"
echo "  Aplicación lista. Iniciando servicios..."
echo "============================================"

# Ejecutar el comando principal (supervisord)
exec "$@"
