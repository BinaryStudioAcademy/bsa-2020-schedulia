build-image:
	cd .config/docker/$(IMAGE) && \
	docker build -t schedulia/$(IMAGE):$(VERSION) . && \
	docker push schedulia/$(IMAGE):$(VERSION)

build:
	cd ${SOURCE}/.deploy/${PROVIDER} && \
	./build.sh

deploy:
	cd ${SOURCE}/.deploy/${PROVIDER} && \
	./deploy.sh

build-api-staging:
	make build SOURCE=api PROVIDER=heroku

deploy-api-staging:
	make deploy SOURCE=api PROVIDER=heroku

build-client-staging:
	make build SOURCE=client PROVIDER=heroku

deploy-client-staging:
	make deploy SOURCE=client PROVIDER=heroku

build-api-production:
	make build SOURCE=api PROVIDER=cloudRun

deploy-api-production:
	make deploy SOURCE=api PROVIDER=cloudRun

build-client-production:
	make build SOURCE=client PROVIDER=cloudRun

deploy-client-production:
	make deploy SOURCE=client PROVIDER=cloudRun

worker-logs:
	heroku logs -a schedulia-api --dyno=worker --tail
