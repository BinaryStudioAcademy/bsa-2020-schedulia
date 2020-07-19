FROM nginx:1.19.1

COPY .deploy/heroku/nginx-site.conf /etc/nginx/templates/default.conf.template
COPY . /usr/share/nginx/html

RUN rm -rf /usr/share/nginx/html/.deploy
