#!/bin/sh
set -x

UBIZ_SERVER=103.1.236.235
UBIZ_BRANCH=$1

ssh -o 'StrictHostKeyChecking=no' root@${UBIZ_SERVER} mkdir -p /home/${UBIZ_BRANCH}