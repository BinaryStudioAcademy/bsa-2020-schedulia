FROM schedulia/php-base:0.0.1

ENV PORT=8000

USER root

COPY ./entrypoint.sh /etc/entrypoint.sh

RUN apt-get update && apt-get -y --no-install-recommends install \
	nginx \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
	&& chmod +x /etc/entrypoint.sh