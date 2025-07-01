FROM docker.angie.software/angie:1.7.0-minimal

WORKDIR "/home/phpdoc"

COPY --chown=root:root ./docker/angie/http.d/default.conf /etc/angie/http.d/default.conf

COPY --chown=root:root ./docker/angie/certs/localhost.crt /etc/angie/certs/localhost.crt
COPY --chown=root:root ./docker/angie/certs/localhost.key /etc/angie/certs/localhost.key
