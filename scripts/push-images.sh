#!/bin/bash
set -exuo pipefail

APP_IMAGE_NAME_NAMESPACE=beta-shop
DOCKER_IMAGE_VERSION=1.0
INTERNAL_CONTAINER_REGISTRY=registry.k8s.spryker-solution.nfq.internal

for IMAGE_SUFFIX in app frontend cli
do
    DOCKER_IMAGE=${APP_IMAGE_NAME_NAMESPACE}_${IMAGE_SUFFIX}
    docker image tag ${DOCKER_IMAGE}:${DOCKER_IMAGE_VERSION} ${INTERNAL_CONTAINER_REGISTRY}/${DOCKER_IMAGE}:${DOCKER_IMAGE_VERSION}
    docker image push --all-tags ${INTERNAL_CONTAINER_REGISTRY}/${DOCKER_IMAGE}
done
