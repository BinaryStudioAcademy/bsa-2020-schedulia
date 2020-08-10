#/bin/bash
cd ../..

gsutil cp gs://schedulia-access/.env.staging .env
composer install --no-dev --optimize-autoloader

docker build -f ./.deploy/heroku/Dockerfile -t schedulia/staging:latest .

docker build -f ./.deploy/heroku/Dockerfile.web -t registry.heroku.com/schedulia-api/web .
docker push registry.heroku.com/schedulia-api/web

docker build -f ./.deploy/heroku/Dockerfile.worker -t registry.heroku.com/schedulia-api/worker .
docker push registry.heroku.com/schedulia-api/worker
