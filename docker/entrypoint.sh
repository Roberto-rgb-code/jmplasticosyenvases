#!/bin/bash
set -e

cd /var/www/html

if [ ! -f .env ]; then
  cp .env.example .env
fi

# Sync DB settings from container env into .env for artisan
php -r '
$env = file_exists(".env") ? file_get_contents(".env") : "";
$map = [
  "APP_NAME" => getenv("APP_NAME") ?: "JM Plasticos y Envases",
  "APP_ENV" => getenv("APP_ENV") ?: "local",
  "APP_DEBUG" => getenv("APP_DEBUG") ?: "true",
  "APP_URL" => getenv("APP_URL") ?: "http://localhost:8080",
  "DB_CONNECTION" => getenv("DB_CONNECTION") ?: "mysql",
  "DB_HOST" => getenv("DB_HOST") ?: "db",
  "DB_PORT" => getenv("DB_PORT") ?: "3306",
  "DB_DATABASE" => getenv("DB_DATABASE") ?: "jmplasticos",
  "DB_USERNAME" => getenv("DB_USERNAME") ?: "jmplasticos",
  "DB_PASSWORD" => getenv("DB_PASSWORD") ?: "secret",
  "CONTACT_PHONE" => getenv("CONTACT_PHONE") ?: "",
  "CONTACT_EMAIL" => getenv("CONTACT_EMAIL") ?: "",
];
foreach ($map as $k => $v) {
  $line = $k . "=" . (str_contains((string)$v, " ") ? "\"$v\"" : $v);
  if (preg_match("/^{$k}=.*/m", $env)) {
    $env = preg_replace("/^{$k}=.*/m", $line, $env);
  } else {
    $env .= "\n" . $line;
  }
}
file_put_contents(".env", $env);
'

if [ ! -d vendor ] || [ ! -f vendor/autoload.php ]; then
  echo "Instalando dependencias Composer..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

echo "Esperando MySQL..."
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '3306'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0); } catch (Exception \$e) { exit(1); }" 2>/dev/null; do
  sleep 2
done
echo "MySQL listo."

if ! grep -qE '^APP_KEY=base64:.+' .env; then
  php artisan key:generate --force
fi

php artisan storage:link --force 2>/dev/null || true
php artisan migrate --force

# Seed productos solo si la tabla está vacía
php -r '
require "vendor/autoload.php";
$app = require "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
if (\App\Models\Producto::count() === 0) {
  echo "Sembrando productos...\n";
  Artisan::call("db:seed", ["--class" => "ProductoSeeder", "--force" => true]);
  echo Artisan::output();
}
'

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

exec "$@"
