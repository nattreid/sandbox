#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
ROOT_FOLDER=$(dirname $DIR)

DEFAULT_PWD=$PWD

cd ${ROOT_FOLDER}
git checkout -- app/
git checkout -- bin/
git pull
rm temp/cache/* -rf
rm www/webtemp/* -rf