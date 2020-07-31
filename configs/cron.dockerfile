FROM alpine

COPY ./configs/crontab /etc/crontab

RUN crontab /etc/crontab

CMD /usr/sbin/crond -f -l 8
