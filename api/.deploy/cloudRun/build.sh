#/bin/bash
cd ../..

gsutil cp gs://schedulia-access/.env.production .env
composer install --no-dev --optimize-autoloader

gcloud builds submit --config ./.deploy/cloudRun/cloudbuild.yaml \
	--substitutions _REGION=$GCP_REGION
