# Spryker B2C Demo Shop
[![Build Status](https://travis-ci.com/spryker/b2c-demo-shop-internal.svg?token=uuNLarTLvJGpcdGUgqj2&branch=master)](https://travis-ci.com/spryker/b2c-demo-shop-internal)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)

## Vagrant Installation
In order to install the B2C Demo Shop on your machine, you can follow the instructions described in the link below:

* [Installation Guide](http://documentation.spryker.com/content/dev-getting-started.htm)

__NOTE: instead of `vagrant up` run `VM_PROJECT=suite SPRYKER_REPOSITORY="git@github.com:spryker-shop/b2c-demo-shop.git" vagrant up`__.

If you encounter any issues during or after installation, you can first check our Troubleshooting article:

* [Troubleshooting](http://documentation.spryker.com/content/installation/troubleshooting.htm)

## Docker installation

For troubleshooting, please, refer to [Troubleshooting](https://documentation.spryker.com/docs/spryker-in-docker-troubleshooting)

### Preparation

Please, follow the instructions: [Prerequisites](https://documentation.spryker.com/docs/docker-installation-prerequisites).

Make sure docker 18.09.1+ and docker-compose 1.23+ are installed:

- $ docker version
- $ docker-compose --version

Mac users would increase vCPU and RAM dedicated for docker:
- **4 vCPU** and **6GB RAM** for 15' Macbook
- 2 vCPU and 4GB RAM for 13' Macbook

### Installation

```bash
mkdir b2c-demo-shop && cd b2c-demo-shop
git clone https://github.com/spryker/b2c-demo-shop-internal.git ./
```

```bash
git clone git@github.com:spryker/docker-sdk.git docker
echo "127.0.0.1 zed.de.spryker.com yves.de.spryker.com glue.de.spryker.com zed.at.spryker.com yves.at.spryker.com glue.at.spryker.com zed.us.spryker.com yves.us.spryker.com glue.us.spryker.com mail.spryker.com scheduler.spryker.com queue.spryker.com" | sudo tee -a /etc/hosts
```

### Production-like environment

#### I. The very first run (after the project is cloned)
```bash
docker/sdk boot -s
docker/sdk up
```

#### II. Git checkout with assets and data
```bash
git checkout {your_branch_name}
docker/sdk boot -s
docker/sdk up --assets --data
```

! `up` command arguments are optional !

- `--assets` To get assets be built. Can be skipped.
- `--data` To get new demo data. Can be skipped.

#### III. Git checkout light
```bash
git checkout {your_branch_name}
docker/sdk boot -s
docker/sdk up
```

#### IV. Full data reload.
```bash
docker/sdk clean-data && docker/sdk up && docker/sdk console q:w:s -v -s
```

### Developer environment

#### I. The very first run (after clone)
```bash
docker/sdk boot deploy.dev.yml
docker/sdk up
```

#### II. Git checkout
```bash
git checkout {your_branch_name} && docker/sdk boot -s deploy.dev.yml

docker/sdk up --build --assets --data
```
! `up` command arguments are optional !

- `--build` To get composer be updated, transfer be generated, etc. Can be skipped if no related changes.
- `--assets` To get assets be built. Can be skipped.
- `--data` To get new demo data and infrastructure. Can be skipped.

#### III. Code reload.
```bash
docker/sdk trouble
rm -rf ./docker && docker/sdk boot -s deploy.dev.yml
docker/sdk up --build --assets
```

#### IV. Full data reload.
```bash
docker/sdk trouble
rm -rf ./docker && docker/sdk boot -s deploy.dev.yml
docker/sdk up --build --assets --data
```
