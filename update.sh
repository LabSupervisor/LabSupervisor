#!/bin/bash

echo "Get latest update..."
git checkout main
git pull

# Database update
export $(grep -v '^#' ".env" | grep 'DATABASE_' | sed 's/ *= */=/g')

LATEST_SQL_FILE=$(ls -t "sql/patches/"*.sql | head -n 1)

echo "Start application update..."

echo "Start database update..."
ERROR_OUTPUT=$(mysql -h $DATABASE_HOST -P "$DATABASE_PORT" -u $DATABASE_USER -p"$DATABASE_PASSWORD" $DATABASE_NAME < "$LATEST_SQL_FILE" 2>&1)

if [ $? -eq 0 ]; then
  echo "Database updated."
else
  echo "Failed to update database: $ERROR_OUTPUT"
  exit 1
fi

# Module update
echo "Start application module update..."
composer update

echo "Application module updated."

# Video server update
echo "Start video server update..."
cd server/
npm i
echo "Video server updated."
