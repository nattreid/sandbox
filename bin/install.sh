#!/bin/bash
WWW_FOLDER="www"
APP_FOLDER="app"
BIN_FOLDER="bin"

help() {
    echo "Instalace Nette"
    echo "Nastavi prava adresaru, stahne composer a aktualizuje knihovnu"
}

setRights() {
    DEFAULT_PWD=$PWD
    cd ${ROOT_FOLDER}

    chmod 777 temp log sessions ${WWW_FOLDER}/webtemp ${WWW_FOLDER}/assets ${WWW_FOLDER}/upload -R

    cd ${DEFAULT_PWD}
}

setConfig() {
    DEFAULT_PWD=$PWD
    cd ${ROOT_FOLDER}/${APP_FOLDER}/config

    echo "" > config.local.neon

    cd ${DEFAULT_PWD}
}

updateComposer() {
    DEFAULT_PWD=$PWD
    cd ${ROOT_FOLDER}/${BIN_FOLDER}

    php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
    php -r "if (hash_file('SHA384', 'composer-setup.php') === 'a52be7b8724e47499b039d53415953cc3d5b459b9d9c0308301f867921c19efc623b81dfef8fc2be194a5cf56945d223') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    
    cd ${ROOT_FOLDER}

    ./${BIN_FOLDER}/composer.phar update
    
    mkdir -p ~/bin
    cp ./${BIN_FOLDER}/composer.phar ~/bin/composer # nebo /usr/local/bin/composer pro vsechny

    cd ${DEFAULT_PWD}
}

if [ $# -gt 0 ]; then
    if [ $1 = "-?" ]; then
        help
        exit 0
    fi
fi

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
ROOT_FOLDER=$(dirname $DIR)

setRights
setConfig
updateComposer
