build:
	cd .config/docker/$(IMAGE) && \
	docker build -t schedulia/$(IMAGE):$(VERSION) . && \
	docker push schedulia/$(IMAGE):$(VERSION)
build-api-staging:
	cd api/.deploy/heroku && \
	./build.sh
deploy-api-staging:
	cd api/.deploy/heroku && \
	./deploy.sh
build-client-staging:
	cd client/.deploy/heroku && \
	./build.sh
deploy-client-staging:
	cd client/.deploy/heroku && \
	./deploy.sh