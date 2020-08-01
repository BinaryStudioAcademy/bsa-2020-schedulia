#/bin/bash
cd ../..

gsutil cp gs://schedulia-access/.env.client.production .env.local
npm ci
npm run build

gcloud builds submit --config ./.deploy/cloudRun/cloudbuild.yaml
