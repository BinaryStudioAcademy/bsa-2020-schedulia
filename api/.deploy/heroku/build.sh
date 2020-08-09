#/bin/bash
cd ../..

echo "[INFO] Preparing files"

gsutil cp gs://schedulia-access/.env.staging .env.staging
cp ./.deploy/heroku/Dockerfile Dockerfile
cp ./.deploy/heroku/heroku.yml ../heroku.yml

cd ..

echo "[INFO] Setting up heroku"

heroku git:remote -a schedulia-api
heroku stack:set container

LAST_COMMIT=$(git rev-parse HEAD)
CURRENT_BRANCH=$(git branch --show-current)

git add .
git commit -m "deploy_staging"

echo "[INFO] Deploying..."

git push heroku $CURRENT_BRANCH:master --force

echo "[INFO] Rollback changes"

rm heroku.yml
rm api/Dockerfile
rm api/.env.staging

git reset $LAST_COMMIT

echo "[INFO] Finished"