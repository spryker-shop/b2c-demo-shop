# Spryker B2C Demo Shop
[![Build Status](https://github.com/spryker-shop/b2c-demo-shop/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/spryker-shop/b2c-demo-shop/actions?query=branch:master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spryker-shop/b2c-demo-shop/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/spryker-shop/b2c-demo-shop/?branch=master)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg)](https://php.net/)

## Vagrant Installation
To install the B2C Demo Shop in Vagrant on your machine, follow [Developer Getting Started Guide](https://documentation.spryker.com/docs/dev-getting-started).

__NOTE: instead of `vagrant up` run `VM_PROJECT=suite SPRYKER_REPOSITORY="git@github.com:spryker-shop/b2c-demo-shop.git" vagrant up`__.

For common installation issues, check [Troubleshooting](https://documentation.spryker.com/docs/troubleshooting).

## Docker installation

For detailed installation instructions of Spryker in Docker, see [Getting Started with Docker](https://documentation.spryker.com/docs/getting-started-with-docker).

For troubleshooting of Docker based instanaces, see [Troubleshooting](https://documentation.spryker.com/docs/spryker-in-docker-troubleshooting).

### Prerequisites

For the installation prerequisites, see [Docker Installation Prerequisites](https://documentation.spryker.com/docs/docker-installation-prerequisites).

Recommended system requirements for MacOS:

|Macbook type|vCPU| RAM|
|---|---|---|
|15' | 4 | 6GB |
|13' | 2 | 4GB |

### Installation

Run the commands:
```bash
mkdir spryker-b2c && cd spryker-b2c
git clone https://github.com/spryker-shop/b2c-demo-shop.git ./
git clone git@github.com:spryker/docker-sdk.git docker
```

### Production-like environment

1. Run the following commands right after cloning the repository:

```bash
docker/sdk boot -s
```

> Please, follow the recommendations in output in order to prepare the environment.

```bash
docker/sdk up
```

2. Git checkout with assets and importing data:

```bash
git checkout your_branch
docker/sdk boot -s
docker/sdk up --assets --data
```

> Optional `up` command arguments:
>
> - `--assets` - build assets
> - `--data` - get new demo data

3. Light git checkout:

```bash
git checkout your_branch
docker/sdk boot -s

docker/sdk up
```

4. Reload all the data:

```bash
docker/sdk clean-data && docker/sdk up && docker/sdk console q:w:s -v -s
```

### Developer environment

1. Run the commands right after cloning the repository:

```bash
docker/sdk boot deploy.dev.yml
```

> Please, follow the recommendations in output in order to prepare the environment.

```bash
docker/sdk up
```

2. Git checkout:

```bash
git checkout your_branch
docker/sdk boot -s deploy.dev.yml
docker/sdk up --build --assets --data
```

> Optional `up` command arguments:
>
> - `--build` - update composer, generate transfer objects, etc.
> - `--assets` - build assets
> - `--data` - get new demo data

3. If you get unexpected application behavior or unexpected errors:

    1. Run the command:
    ```bash
    git status
    ```

    2. If there are unnecessary untracked files (red ones), remove them.

    3. Restart file sync and re-build the codebase:
    ```bash
    docker/sdk trouble
    docker/sdk boot -s deploy.dev.yml
    docker/sdk up --build --assets
    ```

4. If you do not see the expected demo data on the Storefront:

    1. Check the queue broker and wait until all queues are empty.

    2. If the queue is empty but the issue persists, reload the demo data:
    ```bash
    docker/sdk trouble
    docker/sdk boot -s deploy.dev.yml
    docker/sdk up --build --assets --data
    ```

### Troubleshooting

**No data on Storefront**

Use the following services to check the status of queues and jobs:
- queue.spryker.local
- scheduler.spryker.local

**Fail whale**

1. Run the command:
```bash
docker/sdk logs
```
2. Add several returns to mark the line you started from.
3. Open the page with the error.
4. Check the logs.

**MacOS and Windows - files synchronization issues in Development mode**

1. Follow sync logs:
```bash
docker/sdk sync logs
```
2. Hard reset:
```bash
docker/sdk trouble && rm -rf vendor && rm -rf src/Generated && docker/sdk sync && docker/sdk up
```

**Errors**

`ERROR: remove spryker_logs: volume is in use - [{container_hash}]`

1. Run the command:
```bash
docker rm -f {container_hash}
```
2. Repeat the failed command.

`Error response from daemon: OCI runtime create failed: .... \\\"no such file or directory\\\"\"": unknown.`

Repeat the failed command.
