#!/bin/bash
ASSETS="www/assets"
UPLOAD="www/upload"

help() {
    echo "Zaloha"
    echo "Databaze se zalohuje pod prvnim uctem v config.neon (default)"
}

createBackup() {
    DEFAULT_PWD=$PWD
    cd ${ROOT_FOLDER}/bin

    LOGIN=$(cat ../app/config/project.neon | grep -m1 -oP 'username: \K(.*)$')
    PASSWORD=$(cat ../app/config/project.neon | grep -m1 -oP 'password: \K(.*)$')

    mkdir -p backup
    cd backup

    tar -zcf files.tar.gz ${ROOT_FOLDER}/${ASSETS} ${ROOT_FOLDER}/${UPLOAD}

    mysqldump -u${LOGIN} -p${PASSWORD} --all-databases --routines --single-transaction | gzip > database.sql.gz

    tar -cf backup$(date +"%m_%d_%Y").tar files.tar.gz database.sql.gz

    rm files.tar.gz database.sql.gz
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

createBackup
