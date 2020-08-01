FROM nginx:1.19.1

COPY .deploy/shared/nginx-site.conf /etc/nginx/templates/default.conf.template
COPY ./dist /usr/share/nginx/html
