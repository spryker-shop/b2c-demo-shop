#!/bin/bash
###
### download-and-cache — downloads a file and caches it,
###                      preventing multiple downloads
###
### Usage:
###   download-and-cache <URL> <CACHE_DIR>
###
### Options:
###   <URL>        Input file to read.
###   <CACHE_DIR>  Output file to write. Use '-' for stdout.
###   -h           Show this message.

die()
{
    echo "error: Download of ${URL} failed."
    [ -f ${CACHE_DIR} ] && rm -f ${CACHE_DIR}
    exit 1
}

help() {
    sed -rn 's/^### ?//;T;p' "$0"
}

if [[ $# -ne 2 ]] || [[ "$1" == "-h" ]]; then
    help
    exit 1
fi

URL=$1
CACHE_DIR=$2

wget -q -c ${URL} -P ${CACHE_DIR} || die
