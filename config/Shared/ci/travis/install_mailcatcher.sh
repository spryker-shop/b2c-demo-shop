#!/usr/bin/env bash

set -e

gem install mailcatcher --no-document > /dev/null
mailcatcher > /dev/null
