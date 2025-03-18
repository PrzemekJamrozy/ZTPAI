FROM node:22

WORKDIR /app

COPY ./package.json *yarn* ./

EXPOSE 3000
ENTRYPOINT ["/bin/sh", "-c", "yarn && yarn start"]