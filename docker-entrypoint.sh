#!/bin/sh

echo "Esperando banco de dados ficar disponível..."

while ! nc -z db 3306; do
  echo "Banco não disponível ainda, esperando 3 segundos..."
  sleep 3
done

echo "Banco disponível!"

# Verifica se já rodou migrations/config antes
if [ ! -f /var/www/html/.initialized ]; then
  echo "Rodando migrations e configuracoes iniciais..."
  php artisan migrate --force

  if [ ! -L public/storage ]; then
    php artisan storage:link
  fi

  php artisan config:clear
  php artisan config:cache

  # Cria arquivo de flag para não rodar de novo
  touch /var/www/html/.initialized
else
  echo "Já rodou migrations e config antes, pulando..."
fi

echo "Iniciando Apache..."

exec apache2-foreground
