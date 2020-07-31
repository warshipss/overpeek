FROM node:10-alpine

WORKDIR /app

EXPOSE 3000

ENV NUXT_HOST=0.0.0.0
ENV NODE_ENV=$APP_ENV

COPY ./configs/website-entrypoint.sh /usr/local/bin/

RUN apk --no-cache add bash \
    && chmod +x /usr/local/bin/website-entrypoint.sh

ENTRYPOINT ["website-entrypoint.sh"]
