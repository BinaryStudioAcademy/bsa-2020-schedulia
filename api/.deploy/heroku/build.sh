#/bin/bash
cd ../..

docker build -f ./.deploy/heroku/Dockerfile -t registry.heroku.com/schedulia-api/web .
docker push registry.heroku.com/schedulia-api/web
