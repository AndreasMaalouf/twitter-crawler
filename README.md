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

```bash
# fetch the top instruments in the last 1000 days
curl 0.0.0.0/metrics/1000

# fetch the top instruments historically
curl 0.0.0.0/top
```

### How it works

#### Ingesting the tweets
1. Job runs depending on the priority of the twitter user.
2. Crawls page using Spatie's Crawler and Browsershot.
3. Extract crawled data using DOMdocument and DOMXPath.
4. Fire event with a queued listener to ingest the tweet.
5. After ingestion another event with a queued listener is fired to parse the tweet and mark it as processed.
6. Crawling failures will be stored to be reprocessed.

#### Showing the statistics
> The data will be changing every few minutes so a job will be running to the data that will be shown to the user.
>
> This cached data is what will be returned to the user through the website or through the apis.

1. Repository classes are injected into the controllers.
2. Repository will attempt to fetch the data from cache.
3. If no data was found repository will fall back to db and cache the results.