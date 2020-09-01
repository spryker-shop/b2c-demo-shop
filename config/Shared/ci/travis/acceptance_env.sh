#!/bin/bash -e

# # provide antelope legacy
# FE_ANTELOPE_LEGACY=false

# # package manager (npm|yarn)
# FE_PACKAGE_MANAGER='npm'

# # install command (add flags/args here if you need)
# FE_INSTALL_COMMAND='install'

# # yves
# FE_YVES_SCRIPT='yves'
# FE_YVES_BUNDLE_PKGJSON_PATTERN=".+/assets/Yves/package.json$"

# # zed
# FE_ZED_SCRIPT='zed'
# FE_ZED_BUNDLE_PKGJSON_PATTERN=".+/assets/Zed/package.json$"

sudo apt-get -qqy install apache2

config/Shared/ci/travis/install_mod_fastcgi.sh

sudo chmod -R 755 $HOME
sudo chmod 600 config/Zed/dev_only_private.key
sudo chmod 600 config/Zed/dev_only_public.key

# setup php-fpm
if [[ ${TRAVIS_PHP_VERSION:0:1} = "7" ]]; then sudo cp config/Shared/ci/travis/www.conf.php7 ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.d/www.conf; fi
sudo cp ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf.default ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf
echo "session.save_path = '/tmp'" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
echo "cgi.fix_pathinfo = 1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
~/.phpenv/versions/$(phpenv version-name)/sbin/php-fpm

# apache: modules and rewrite configuration
sudo a2enmod rewrite actions fastcgi alias
sudo cp -f config/Shared/ci/travis/.htaccess .htaccess

# apache: virtual hosts configuration
sudo cp -f config/Shared/ci/travis/travis-ci-apache-yves /etc/apache2/sites-available/yves.conf
sudo cp -f config/Shared/ci/travis/travis-ci-apache-zed /etc/apache2/sites-available/zed.conf
sudo cp -f config/Shared/ci/travis/travis-ci-apache-glue /etc/apache2/sites-available/glue.conf
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/yves.conf
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/zed.conf
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/glue.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/yves.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/zed.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/glue.conf
sudo sed -e "s?%POSTGRES_PORT%?$POSTGRES_PORT?g" --in-place /etc/apache2/sites-available/zed.conf
sudo ln -s /etc/apache2/sites-available/yves.conf /etc/apache2/sites-enabled/yves.conf
sudo ln -s /etc/apache2/sites-available/zed.conf /etc/apache2/sites-enabled/zed.conf
sudo ln -s /etc/apache2/sites-available/glue.conf /etc/apache2/sites-enabled/glue.conf

# apache: fastcgi/php-fpm configuration
sudo cp -f config/Shared/ci/travis/php7-fpm.conf /etc/apache2/conf-enabled/php7-fpm.conf

# apache: check configuration and start service
sudo apachectl configtest
sudo service apache2 restart

# node.js is required - it is installed by '- nvm install (...)' in .travis.yml

# codeception
wget https://raw.github.com/Codeception/c3/2.0/c3.php > /dev/null
