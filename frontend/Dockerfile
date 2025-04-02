FROM node:22

WORKDIR /app

COPY ./package.json ./

EXPOSE 5173
ENTRYPOINT ["/bin/sh", "-c", "npm i && npm run dev"]