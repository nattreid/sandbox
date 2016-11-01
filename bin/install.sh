#!/bin/bash
WWW_FOLDER="www"
APP_FOLDER="app"
BIN_FOLDER="bin"
TEMP_FOLDER="temp"

help() {
    echo "Instalace Nette"
    echo "Nastavi prava adresaru, stahne composer a aktualizuje knihovnu"
}

setRights() {
    DEFAULT_PWD=$PWD
    cd ${ROOT_FOLDER}

    chmod 777 temp log ${WWW_FOLDER}/webtemp ${WWW_FOLDER}/assets ${WWW_FOLDER}/upload -R

    cd ${DEFAULT_PWD}
}

setConfig() {
    DEFAULT_PWD=$PWD
    cd ${ROOT_FOLDER}/${APP_FOLDER}/config

    echo "" > config.local.neon

    cd ${DEFAULT_PWD}
}

prepareComposer() {
    DEFAULT_PWD=$PWD
    cd ${ROOT_FOLDER}/${TEMP_FOLDER}

    EXPECTED_SIGNATURE=$(wget https://composer.github.io/installer.sig -O - -q)
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');")

    if [ "$EXPECTED_SIGNATURE" = "$ACTUAL_SIGNATURE" ]
    then
        php composer-setup.php --quiet
        RESULT=$?
        rm composer-setup.php
    else
        >&2 echo 'ERROR: Invalid installer signature'
        rm composer-setup.php
        exit 1
    fi
    
    cd ${ROOT_FOLDER}

    ./${TEMP_FOLDER}/composer.phar update
    
    mkdir -p ~/bin
    cp ./${TEMP_FOLDER}/composer.phar ~/bin/composer # nebo /usr/local/bin/composer pro vsechny

    cd ${DEFAULT_PWD}
}

prepareScripts() {
    DEFAULT_PWD=$PWD
    cd ${ROOT_FOLDER}

    npm install
    bower install
    gulp

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
prepareComposer
prepareScripts
