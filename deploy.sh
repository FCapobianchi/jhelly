#!/bin/bash
if [ -z "$1" ]
then
   echo "Path di destinazione non specificato."
   exit
fi

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
DEPLOY_DIR=$1

# Sistemo i permessi per evitare problemi durante il backup dei file
sudo chown -R www-data:www-data "${DEPLOY_DIR}"
sudo find "${DEPLOY_DIR}" -type d -exec chmod 755 {} +
sudo find "${DEPLOY_DIR}" -type f -exec chmod 644 {} +

# eseguo la pull del progetto
git -C "${SCRIPT_DIR}" fetch
git -C "${SCRIPT_DIR}" pull
git -C "${SCRIPT_DIR}" checkout main -f

#eseguo l'rsync sulla cartella del webserver
sudo rsync -avzh --exclude-from="${SCRIPT_DIR}/deploy.txt" "${SCRIPT_DIR}/" "${DEPLOY_DIR}/"

# Sistemo i permessi per evitare problemi
sudo chown -R www-data:www-data "${DEPLOY_DIR}"
sudo find "${DEPLOY_DIR}" -type d -exec chmod 755 {} +
sudo find "${DEPLOY_DIR}" -type f -exec chmod 644 {} +
sudo rm -rf "${DEPLOY_DIR}"/temp/cache/*
# Capire come escludere solo quella dir dal deploy
sudo rm -rf "${DEPLOY_DIR}"/assets/