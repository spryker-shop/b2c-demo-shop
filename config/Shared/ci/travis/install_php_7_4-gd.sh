#!/bin/bash

mkdir /home/travis/php74
wget -O - https://www.php.net/distributions/php-7.4.0.tar.gz | tar xz --directory=/home/travis/php74 --strip-components=1 > /dev/null
cd /home/travis/php74/ext/gd
phpize
./configure --enable-gd --with-jpeg --with-freetype
make
sudo make install
echo "extension = gd.so" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
