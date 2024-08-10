# SSL-Check: Web Application for SSL Certificate Verification

SSL-Check is a web application designed to verify the SSL certificate of any web domain. This tool is useful for quickly checking the validity and details of SSL certificates, ensuring that your website is secure and compliant.

## Deployment Instructions

You have two options to deploy this web application:

### 1. Host on a Web Server

To deploy the application manually:

1. Clone this repository to your local machine.
2. Host the `webapp` directory on a web server that supports PHP.

That’s it! Your SSL checker will be up and running.

### 2. Use the Pre-built Docker Container

Alternatively, you can deploy the application using a pre-built Docker container:

- Pull the latest image from Docker Hub:

  ```bash
  docker pull henrybravo/ssl-checker-webapp:latest
  ```

## Building and Pushing Docker Images

The Docker image for this application is automatically built using GitHub Actions and pushed to Docker Hub as a public image. You can find the latest builds [here](https://hub.docker.com/r/henrybravo/ssl-checker-webapp).

For those interested in deploying to Azure Container Registry (ACR), an example pipeline configuration is available in the [Azure Pipelines branch](https://github.com/henrybravo/ssl-check/blob/azure-pipelines/.github/workflows/deploy.yml).

## Deployment to Azure Container Apps

This containerized application can be deployed to Azure Container Apps (ACA). A continuous integration (CI) pipeline for this deployment is available [here](https://gitlab.com/henrybravo/tf-azure-container-app/).

## Live Demo

Try out the demo version of the SSL Checker [here](https://dev-ssl-checker-webapp.redwave-86e6e6c2.northeurope.azurecontainerapps.io).

Note: The demo app is configured to scale to zero when idle, so the first request may take approximately 30 seconds to start as the container instantiates on Azure.

## Development Insights

This web application is developed using PHP and JavaScript, with significant contributions from GitHub Copilot. The project was an experiment in utilizing AI-powered code suggestions, showcasing the potential for rapid development. The experience was not only productive but also highly enjoyable.

---

Feel free to contribute to this project or reach out with any questions. Your feedback is always appreciated!
