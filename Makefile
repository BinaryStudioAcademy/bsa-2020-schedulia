build:
	cd .config/docker/$(IMAGE) && \
	docker build -t schedulia/$(IMAGE):$(VERSION) . && \
	docker push schedulia/$(IMAGE):$(VERSION)
deploy-api-staging:
	cd api/.deploy/heroku && \
	./build.sh && \
	./deploy.sh
deploy-client-staging:
	cd client/.deploy/heroku && \
	./build.sh && \
	./deploy.sh