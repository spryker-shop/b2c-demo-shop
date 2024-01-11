#!/bin/bash

set -e

/bin/bash config/Shared/ci/ga/prepare_file_system.sh

echo "vendor/bin/console transfer:generate"
vendor/bin/console transfer:generate

echo "vendor/bin/console propel:install"
vendor/bin/console propel:install

echo "vendor/bin/console dev:ide-auto-completion:generate"
vendor/bin/console dev:ide-auto-completion:generate

echo "vendor/bin/codecept build --ansi"
vendor/bin/codecept build --ansi

echo "vendor/bin/console transfer:databuilder:generate"
vendor/bin/console transfer:databuilder:generate

echo "vendor/bin/console setup:search"
vendor/bin/console setup:search

echo "vendor/bin/console rest-api:generate:documentation"
vendor/bin/console rest-api:generate:documentation

echo "vendor/bin/console frontend:project:install-dependencies"
vendor/bin/console frontend:project:install-dependencies

echo "vendor/bin/console frontend:yves:install-dependencies"
vendor/bin/console frontend:yves:install-dependencies
