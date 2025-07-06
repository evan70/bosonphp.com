#!/usr/bin/env bash
set -e

# ------------------------------------------------------------------------------
#   Generate Dev Keys
# ------------------------------------------------------------------------------

if [ ! -f /home/boson/bosonphp.com/config/secrets/dev/auth.key ]; then
  cp -R /home/boson/bosonphp.com/config/secrets/test/auth.key \
        /home/boson/bosonphp.com/config/secrets/dev/auth.key
fi

if [ ! -f /home/boson/bosonphp.com/config/secrets/dev/auth.key.pub ]; then
  cp -R /home/boson/bosonphp.com/config/secrets/test/auth.key.pub \
        /home/boson/bosonphp.com/config/secrets/dev/auth.key.pub
fi

source /usr/local/bin/entrypoint.sh;
