# Checktemperature

This application is a simple working proof-of-concept Laravel project that will get the average weather temperatures on various API services (such as openweather.org).
Currently this application uses services from https://openweathermap.org and  https://www.weatherapi.com

  - Input location for country and city
  - Hit submit button
  - Redirects to /temperature page showing the temperature
  - Search results are cached for 5 minutes and is persisted in the database mySQL.

# Adding weather API services

  - Place new API service class (implementing interface) on App/Services
  - Newly added services will then be pulled automatically through App/Services/MergeWeatherService

Note when creating new service:
  - Below methods should be edited accordingly
  - buildParams() = set up the necessary parameter for the API (since API params defers)
  - getResult() = pull only what is needed from the response (hence temperature)


### Installation
Open command:
```sh
$ composer install
```
### Known bugs
  - Some cities on the dropdown are incorrect which will yield invalid location
  - Intermittent connections between API endpoints :(
  - WeatherApi.com sometimes gives weird temperature vs google weather (even comparing application result vs weatherapi website)
