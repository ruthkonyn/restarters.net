FROM nginx:alpine

# COPY ./nginx/staging.conf /etc/nginx/nginx.conf
COPY ./nginx/staging.conf /etc/nginx/conf.d/staging.conf

CMD ["nginx", "-g", "daemon off;"]