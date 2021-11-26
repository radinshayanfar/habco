FROM nginx:1.20.2-alpine

COPY vhost.conf /etc/nginx/conf.d/default.conf
