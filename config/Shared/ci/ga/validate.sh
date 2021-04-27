#!/bin/bash

set -e

echo 'vendor/bin/console propel:schema:validate'
vendor/bin/console propel:schema:validate

echo 'vendor/bin/console propel:schema:validate-xml-names'
vendor/bin/console propel:schema:validate-xml-names

echo 'vendor/bin/console transfer:validate'
vendor/bin/console transfer:validate

echo 'vendor/bin/console code:sniff:style'
vendor/bin/console code:sniff:style

echo 'vendor/bin/phpmd src/ text vendor/spryker/architecture-sniffer/src/ruleset.xml --minimumpriority 2'
vendor/bin/phpmd src/ text vendor/spryker/architecture-sniffer/src/ruleset.xml --minimumpriority 2

echo 'vendor/bin/phpstan analyze -c phpstan.neon src/ -l 4'
vendor/bin/phpstan analyze -c phpstan.neon src/ -l 4

echo 'node ./frontend/libs/stylelint'
node ./frontend/libs/stylelint

echo 'node ./frontend/libs/tslint stylish'
node ./frontend/libs/tslint stylish
