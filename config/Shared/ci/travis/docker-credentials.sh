#!/bin/bash

sudo apt-get install gnupg2 pass

cd $HOME/other-download && tar -xf docker-credential-pass-v0.6.3-amd64.tar.gz
chmod +x docker-credential-pass && sudo mv docker-credential-pass /usr/local/bin/

mkdir -p $HOME/.docker && touch $HOME/.docker/config.json && echo '{ "credsStore": "pass" }' > ~/.docker/config.json

export GPG_TTY=$(tty)

gpg --batch --passphrase '' \
    --quick-generate-key "Spryker Spryker Cloud Commerce OS <spryker@gmail.com>" rsa1024 cert 30m

GPG_KEY=$(gpg2 --list-secret-keys | grep uid -B 1 | head -n 1 | sed 's/^ *//g')

gpg --batch --passphrase '' \
    --quick-add-key $GPG_KEY rsa1024 sign 30m
gpg --batch --passphrase '' \
    --quick-add-key $GPG_KEY rsa1024 encrypt 30m

pass init $GPG_KEY

echo "${DOCKERHUB_PASSWORD}" | docker login --username "${DOCKERHUB_USERNAME}" --password-stdin
