#!/bin/bash

set -e

env=${APP_ENV:-production}

if [[ "$env" == "dev" ]]; then

    (yarn install)

    exec yarn run dev

else

    (
        yarn install --production \
        && yarn run build
    )

    exec yarn run start

fi
