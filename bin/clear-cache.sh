#!/usr/bin/env bash

paths=(
    "/cli/app/clearcache"
    )

urls=(
    "https://sandbox"
    )

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
ROOT_FOLDER=$(dirname $DIR)

DEFAULT_PWD=$PWD
cd ${ROOT_FOLDER}/bin

for url in "${urls[@]}"
do
	for path in "${paths[@]}"
    do
        wget -qO- --load-cookies cookies.txt "$url$path" &> /dev/null
    done
done

cd ${DEFAULT_PWD}

