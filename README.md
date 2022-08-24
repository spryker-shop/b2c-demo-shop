# Spryker B2C Self Assessment

## Additional packages

composer require friendsofsymfony/ckeditor-bundle

## Requirements

US 1
As a Zed User I want to have dedicated UI to manage FAQs.

Acceptance Criteria:
Module allows a User to create, remove, update and delete entities (CRUD)
Module is available via left navigation
FAQ are stored in database
FAQ entity can be deactivated

Challenge 1: Answer part is editable via WysiWyg.
Challenge 2: FAQ is localized

US 2
As a machine user I want to connect to the eCommerce to expose FAQ data to external applications.

Acceptance Criteria:
Module exposes REST API endpoints to fetch list of entities, and entity by identifier
Module exposes REST API endpoints to create and remove, update, delete entities by identifier (CRUD)
CRUD endpoints are available for logged in users
Errors are properly handled

Challenge 1: Each endpoint is available only if enabled in config file, if not 404 is returned.
Challenge 2: FAQ data are localized when they’re returned.

US 3
As a customer I want to easily navigate to FAQ page so that I don’t have to call support in case of problems.

Acceptance Criteria:
A FAQ page is available via Yves with list of active FAQ entities
Errors are properly handled

Challenge: Pagination is provided

US 4
As a customer I want to mark FAQ entity whether it is helpful or not to let others know if an answer helps.

Acceptance Criteria:
Voting results are visible for guests and logged in users
Voting is available for logged in users only via Yves
Errors are properly handled

Challenge: A customer can add only one vote. After revoking a vote, he can vote again.

US 5
As a machine user I want to mark FAQ entity whether it is helpful or not to integrate external applications.

Acceptance Criteria:
Voting results are visible for guests and logged in users
Voting endpoints are available for logged in users only
Errors are properly handled

Challenge: A customer can add only one vote. After revoking a vote, he can vote again.

US 6
As a system owner I want to be able to batch import FAQ data to pre-populate database.

Acceptance Criteria:
Import file with dummy data is created
Import triggering is available via CLI

Challenge: FAQ data are localized

[![Build Status](https://github.com/spryker-shop/b2c-demo-shop/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/spryker-shop/b2c-demo-shop/actions?query=branch:master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spryker-shop/b2c-demo-shop/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/spryker-shop/b2c-demo-shop/?branch=master)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)

## Description

Spryker B2C Demo Shop is a collection of Spryker B2C-specific features. It suits most projects as a starting point of development and can be used to explore Spryker.

## B2C Demo Shop quick start

This section describes how to get started with the B2C Demo Shop quickly.

For detailed installation instructions, see [Installing Spryker with Docker](https://docs.spryker.com/docs/installing-spryker-with-docker) or [Installing with Development Virtual Machine](https://docs.spryker.com/docs/dev-getting-started#installing-spryker-with-development-virtual-machine).

### Prerequisites

For full installation prerequisites, see one of the following:
* [Installing Docker prerequisites on MacOS](https://docs.spryker.com/docs/installing-docker-prerequisites-on-macos)
* [Installing Docker prerequisites on Linux](https://docs.spryker.com/docs/installing-docker-prerequisites-on-linux)
* [Installing Docker prerequisites on Windows](https://docs.spryker.com/docs/installing-docker-prerequisites-on-windows)

Recommended system requirements for MacOS:

|Macbook type	|vCPU	|RAM|
|---|---|---|
|15'|	4	|6GB|
|13'|	2	|4GB|

### Installing the B2C Demo Shop

To install the B2C Demo Shop:

1. Create a project folder and clone the B2C Demo Shop and the Docker SDK:
```bash
mkdir spryker-b2c && cd spryker-b2c
git clone https://github.com/spryker-shop/b2c-demo-shop.git ./
git clone git@github.com:spryker/docker-sdk.git docker
```

2. Set up a desired environment:
  * [Setting up a development environment](#setting-up-a-development-environment)
  * [Setting up a production-like environment](#setting-up-a-production-like-environment)

#### Setting up a development environment

To set up a development environment:

1. Bootstrap the docker setup:

```bash
docker/sdk boot deploy.dev.yml
```

2. If the command you've run in the previous step returned instructions, follow them.

3. Build and start the instance:
```bash
docker/sdk up
```

4. Switch to your branch, re-build the application with assets and demo data from the new branch:

```bash
git checkout {your_branch}
docker/sdk boot -s deploy.dev.yml
docker/sdk up --build --assets --data
```

> Depending on your requirements, you can select any combination of the following `up` command attributes. To fetch all the changes from the branch you switch to, we recommend running the command with all of them:
> - `--build` - update composer, generate transfer objects, etc.
> - `--assets` - build assets
> - `--data` - get new demo data

You've set up your Spryker B2C Demo Shop and can access your applications.


### Setting up a production-like environment

To set up a production-like environment:

1. Bootstrap the docker setup:

```bash
docker/sdk boot -s
```

2. If the command you've run in the previous step returned instructions, follow them.

3. Build and start the instance:
```bash
docker/sdk up
```

4. Switch to your branch in one of the following ways:

  * Switch to your brunch, re-build the application with assets and demo data from the new branch:

  ```bash
  git checkout {your_branch}
  docker/sdk boot -s
  docker/sdk up --assets --data
  ```

  * Light git checkout:

  ```bash
  git checkout {your_branch}
  docker/sdk boot -s

  docker/sdk up
  ```

  > Depending on your requirements, you can select any combination of the following `up` command attributes. To fetch all the changes from the branch you switch to, we recommend running the command with all of them:
  > - `--build` - update composer, generate transfer objects, etc.
  > - `--assets` - build assets
  > - `--data` - get new demo data

5. Reload all the data:

```bash
docker/sdk clean-data && docker/sdk up && docker/sdk console q:w:s -v -s
```


You've set up your Spryker B2C Demo Shop and can access your applications.

## Troubleshooting installation of the B2C Demo Shop

This section describes the most common issues related to the installation of the B2C Demo Shop.

For a complete troubleshooting, see [Troubleshooting Spryker in Docker issues](https://docs.spryker.com/docs/troubleshooting-spryker-in-docker-issues) or [Troubleshooting Spryker in Vagrant installation issues](https://docs.spryker.com/docs/troubleshooting-spryker-in-vagrant-installation-issues).

**when**

You get unexpected application behavior or errors.

**then**

1. Check the state of the directory:
```bash
git status
```

2. If there are untracked files (returned in red), and they are not necessary, remove them.

3. Restart file synchronization and rebuild the codebase:
```bash
docker/sdk trouble
docker/sdk boot -s deploy.dev.yml
docker/sdk up --build --assets
```

**when**
You do not see the expected demo data on the Storefront.

**then**

1. Open the [queue broker](http://queue.spryker.local) and wait until all the queues are empty.

2. If the queues are empty, and the issue persists, reload the demo data:
```bash
docker/sdk trouble
docker/sdk boot -s deploy.dev.yml
docker/sdk up --build --assets --data
```

## Installation of B2C Demo Shop with Docker

For detailed installation instructions of Spryker with Docker, see [Installing Spryker with Docker](https://docs.spryker.com/docs/installing-spryker-with-docker).


## Installation of B2C Demo Shop with Vagrant
For detailed installation instructions of Spryker with Vagrant, see [Installing with Development Virtual Machine](https://docs.spryker.com/docs/dev-getting-started#installing-spryker-with-development-virtual-machine).



## Glue API reference

See Glue API reference at [REST API reference](https://docs.spryker.com/docs/rest-api-reference#/rest-api-reference).

## Contributing to the repository

For contribution guidelines, see [Code contribution guide](https://docs.spryker.com/docs/code-contribution-guide#code-contribution-guide).
