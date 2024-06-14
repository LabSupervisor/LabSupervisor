#!/bin/bash

# variables
REPO="git@github.com:LabSupervisor/LabSupervisor.git"
DEPLOY_DIR="/var/www/LabSupervisor"
SSH_KEY="$HOME/.ssh/id_rsa"

function update_repo {
    echo "Mise à jour du dépôt..."
    git checkout main && git pull /var/www/LabSupervisor
}

# Supprimer les fichiers non suivis localement
function clean_untracked_files {
    echo "Nettoyage des fichiers non suivis localement..."
    git clean -df
}

clean_untracked_files
update_repo

# Database update
export $(grep -v '^#' ".env" | grep 'DATABASE_' | sed 's/ *= */=/g')

LATEST_SQL_FILE=$(ls -t "sql/patches/"*.sql | head -n 1)

echo "Start application update..."

# Module update
echo "Start application module update..."
composer update

echo "Application module updated..."

echo "Start database update..."
ERROR_OUTPUT=$(mysql -h $DATABASE_HOST -P "$DATABASE_PORT" -u $DATABASE_USER -p"$DATABASE_PASSWORD" $DATABASE_NAME < $LATEST_SQL_FILE)
if [[ $ERROR_OUTPUT == *"ERROR 1050"* ]]; then
    echo "Table already exists, skipping..."
elif [[ $ERROR_OUTPUT == "" ]]; then
    echo "Database updated."
else
    echo "Failed to update database: $ERROR_OUTPUT"
fi
