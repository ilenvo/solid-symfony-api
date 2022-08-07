FROM nginx:alpine

RUN set -ex \
    && apk update \
    && apk add bash

RUN set -ex \
    && rm /etc/nginx/conf.d/default.conf

COPY app.conf /etc/nginx/conf.d/app.conf
