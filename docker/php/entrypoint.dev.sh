#!/usr/bin/env bash
set -e

# ------------------------------------------------------------------------------
#   Generate Dev Keys
# ------------------------------------------------------------------------------

if [ ! -f /home/phpdoc/phpdoc.app/config/secrets/dev/auth.key ]; then
  cp -R /home/phpdoc/phpdoc.app/config/secrets/test/auth.key \
        /home/phpdoc/phpdoc.app/config/secrets/dev/auth.key
fi

if [ ! -f /home/phpdoc/phpdoc.app/config/secrets/dev/auth.key.pub ]; then
  cp -R /home/phpdoc/phpdoc.app/config/secrets/test/auth.key.pub \
        /home/phpdoc/phpdoc.app/config/secrets/dev/auth.key.pub
fi

source /usr/local/bin/entrypoint.sh;
