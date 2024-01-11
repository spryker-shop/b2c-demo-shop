#!/bin/bash

set -e

mkdir -p shared/data/common/jenkins
mkdir -p shared/data/common/jenkins/jobs
mkdir -p data/cache -m 0777
mkdir -p data/logs -m 0777
chmod -R 777 data/
chmod -R 660 config/Zed/dev_only_private.key
chmod -R 660 config/Zed/dev_only_public.key

echo "composer install --optimize-autoloader --no-interaction"

composer install --optimize-autoloader --no-interaction
