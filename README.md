# ssl-check
webapp to check the ssl certificate of a web domain

## how to deploy

1. Just clone this repo and host the webapp directory on a web server with php. That's all.

or

2. Use the pre-build container [henrybravo/ssl-checker-webapp:latest](https://hub.docker.com/r/henrybravo/ssl-checker-webapp)

### demo

A demo version of this webapp is deployed here: [ssl-checker-webapp.whitemushroom-73af22bc.westeurope.azurecontainerapps.io](https://ssl-checker-webapp.whitemushroom-73af22bc.westeurope.azurecontainerapps.io) - *as this az containerapp scales to 0 when idle, it has a cold start of 30 secs to come back up*

### github copilot
This webapp written in php and js is the result of test-driving copilot 'on a sunday afternoon'. The potential of working this way is huge, and the experience is simply awesome!
