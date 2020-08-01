# Schedulia | Frontend

This is a frontend part of Schedulia application.

## Usage

### Install node

Install [node 12](https://nodejs.org/en/) or use [docker](#docker-usage)


### Install dependencies

```bash
# local
npm install

#docker
npm run d-install
```

### Copy .env.example

```bash
cp .env.example .env.local
```

### Run hot-reload to compile for development

```bash
# local
npm run serve

# docker
npm run d-serve
```

Open in browser: [http://localhost:8080](http://localhost:8080)

### Lint and fix files

```bash
# local
npm run lint

# docker
npm run d-lint
```

## Docker usage

In case you would like to use docker, here are the commands:

```bash
docker-compose run --rm node npm install

docker-compose run --rm node npm run serve
```

For Windows and MacOS it is recommended to use local node installation, but it is not required and up to you.

Also, here are shortcuts for commands above:

```
npm run d-serve

npm run d-install

npm run d-install -- <module name>

npm run d-lint
```

## Useful links

- [Lodash](https://lodash.com/docs/4.17.15)
- [Vuetify](https://vuetifyjs.com/en/introduction/why-vuetify/)
- [Vue.js](https://vuejs.org/v2/guide/)
- [Vuex](https://vuex.vuejs.org/guide/)
- [Material design icons](https://materialdesignicons.com/)
