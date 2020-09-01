#!/bin/bash

mkdir /home/travis/elasticsearch
wget -O - https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-6.8.4.tar.gz | tar xz --directory=/home/travis/elasticsearch --strip-components=1 > /dev/null
/home/travis/elasticsearch/bin/elasticsearch --daemonize
