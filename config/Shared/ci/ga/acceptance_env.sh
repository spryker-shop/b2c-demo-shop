#!/bin/bash -e

# Install mail catcher
sudo gem install mailcatcher --no-document > /dev/null
mailcatcher > /dev/null

sudo apt-get -qqy install apache2 apache2-utils

config/Shared/ci/ga/install_mod_fastcgi.sh

sudo chmod -R 755 $HOME
sudo chmod 600 config/Zed/dev_only_private.key
sudo chmod 600 config/Zed/dev_only_public.key

PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION . '.' .  PHP_MINOR_VERSION;")

# setup php-fpm
echo "cp config/Shared/ci/ga/www.conf.php7 /etc/php/$PHP_VERSION/fpm/pool.d/www.conf"
sudo cp config/Shared/ci/ga/www.conf.php7 /etc/php/$PHP_VERSION/fpm/pool.d/www.conf
echo "add ini config"
sudo echo "session.save_path = '/tmp'" >> /etc/php/$PHP_VERSION/cli/php.ini
sudo echo "cgi.fix_pathinfo = 1" >> /etc/php/$PHP_VERSION/cli/php.ini
echo "Restart php-fpm"
sudo service php$PHP_VERSION-fpm restart

# apache: modules and rewrite configuration
sudo a2enmod rewrite actions fastcgi alias
sudo cp -f config/Shared/ci/ga/.htaccess .htaccess

# apache: virtual hosts configuration
sudo cp -f config/Shared/ci/ga/ga-ci-apache-yves /etc/apache2/sites-available/yves.conf
sudo cp -f config/Shared/ci/ga/ga-ci-apache-zed /etc/apache2/sites-available/zed.conf
sudo cp -f config/Shared/ci/ga/ga-ci-apache-glue /etc/apache2/sites-available/glue.conf
sudo sed -e "s?%GITHUB_WORKSPACE%?$(pwd)?g" --in-place /etc/apache2/sites-available/yves.conf
sudo sed -e "s?%GITHUB_WORKSPACE%?$(pwd)?g" --in-place /etc/apache2/sites-available/zed.conf
sudo sed -e "s?%GITHUB_WORKSPACE%?$(pwd)?g" --in-place /etc/apache2/sites-available/glue.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/yves.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/zed.conf
sudo sed -e "s?%DB_PASSWORD%?$DB_PASSWORD?g" --in-place /etc/apache2/sites-available/zed.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/glue.conf
sudo sed -e "s?%POSTGRES_PORT%?$POSTGRES_PORT?g" --in-place /etc/apache2/sites-available/zed.conf
sudo ln -s /etc/apache2/sites-available/yves.conf /etc/apache2/sites-enabled/yves.conf
sudo ln -s /etc/apache2/sites-available/zed.conf /etc/apache2/sites-enabled/zed.conf
sudo ln -s /etc/apache2/sites-available/glue.conf /etc/apache2/sites-enabled/glue.conf

# apache: fastcgi/php-fpm configuration
sudo cp -f config/Shared/ci/ga/php7-fpm.conf /etc/apache2/conf-enabled/php7-fpm.conf

###################### ADD HOSTS ############################

echo "ADD HOSTS"

echo "127.0.0.1 zed.de.spryker.test" | sudo tee -a /etc/hosts
echo "127.0.0.1 glue.de.spryker.test" | sudo tee -a /etc/hosts
echo "127.0.0.1 www.de.spryker.test" | sudo tee -a /etc/hosts

##################################################

# apache: check configuration and start service
echo "RESTART APACHE"

sudo apachectl configtest

sudo service apache2 restart

# codeception
wget https://raw.github.com/Codeception/c3/2.0/c3.php > /dev/null
