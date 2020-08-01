#/bin/bash

gcloud run deploy schedulia-client \
	--image gcr.io/$GCP_PROJECT/schedulia-client \
	--platform managed \
	--region=$GCP_REGION \
  	--allow-unauthenticated
