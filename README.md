# MyTheresa Cart Test

I have developed the test following DDD principles and structure from 
DDD in php book from Carlos Buenosvinos
The Application only uses InMemory repositories with prefilled data, so the data 
is not persisted through requests, but a different implementation 
can be developed and added with minimal changes to the existing code.

To have the development environment set up with docker: 
```
cd docker
docker-compose up -d
docker-compose exec php composer install
```

Aftwerwards the test suite can be run using this command
```
docker-compose exec php php bin/phpunit
```

The application listens on port 80 by default. It can be changed in docker/docker-compose.yml.

The application has 2 endpoints

To add a product to the current user's cart:
PUT /cart/product/add

To retrieve the products in the current user's cart:
GET /cart/product

In order to be able to retrieve the current user the Authorization HTTP header has to contain a bearer token.
There is an accessible user with the "randomgeneratedtoken" token so it is easier to play with the API.

Example cURL calls would be:
```
curl -X GET \
  http://localhost/cart/product \
  -H 'Authorization: Bearer: randomgeneratedtoken' \
  -H 'Content-Type: application/json'
```
```
curl -X PUT \
  http://localhost/cart/product/add \
  -H 'Authorization: Bearer: randomgeneratedtoken' \
  -H 'Content-Type: application/json' \
  -H 'content-length: 19' \
  -d '{
    "productId": 1
}'
```

At first I developed a session based authentication but I scraped it because being a REST API using 
session based authentication made no sense. So I developed a simple token based authentication.

The docker images I developed are focused on development and for the testers. 
Another docker deployment images should be created for the deployment of this app.





