#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
ROOT_FOLDER=$(dirname $DIR)

DEFAULT_PWD=$PWD

cd ${ROOT_FOLDER}
gulp off
git checkout -- app/
git checkout -- bin/
git pull
composer update
bower update
gulp clean
gulp
gulp on