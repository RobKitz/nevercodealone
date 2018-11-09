FROM nginx:alpine
RUN rm -rf /usr/share/nginx/html/*
COPY ./tests/_output/* /usr/share/nginx/html/
COPY report.nginx /etc/nginx/conf.d/default.conf
COPY report.access /etc/nginx/conf/access

