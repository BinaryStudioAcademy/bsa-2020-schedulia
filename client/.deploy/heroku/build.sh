#/bin/bash
cd ../..

gsutil cp gs://schedulia-access/.env.client.staging .env.local
npm install
npm run build

docker build -f ./.deploy/shared/Dockerfile -t registry.heroku.com/schedulia-client/web .
docker push registry.heroku.com/schedulia-client/web
