### Set up
```bash
composer install
create .env and copy .env.example into it
php artisan key:generate


./vendor/bin/sail up
./vendor/bin/sail artisan migrate

# due to the chromium docker container not being able to
# enable javascript the crawler had to be run locally
npm install puppeteer --global

npm install
npm run dev

# run crawler to populate data
php artisan app:run-twitter-crawler
```

### Run tests
```
./vendor/bin/sail test 
```

### Use Web App

> 0.0.0.0 to access the web page after running sail up.
> Top page and metrics page are available after register and log in


### Curl

```
curl 0.0.0.0/metrics/1000

curl 0.0.0.0/top
```