### Introduction

This script will read all the URLs from a specified category on https://www.black-ink.org/

The category will default to 'Digitalia', but any other category could be specified via a `category` GET parameter.

I haven't chosen to use a framework, or any other third party loaded scripts (other than PHP Unit). As this script only has one route, I didn't feel there was a need to add a framework (like slim framework) to handle the routing, or any other aspect of the script.

I would normally use something like Guzzle to handle external HTTP requests, but for the purposes of this script, I felt that would have been unneccessary, as I was mostly using the DOM set of PHP classes anyway, which handle simple http requests for you.

### Usage

From the root directory run:

`composer install` to install dependencies.

and run `php ./public/index.php` to run the script.

If you want to run this script in a browser, the root directory should be `./public/`.




### Unit tests

I've written unit tests to cover the `./src` directory, which can be run using:

`./vendor/bin/phpunit ./tests/`




### Afterthought / Room for improvement

Using Guzzle to handle the http requests would have been a good idea. A number of http requests fail when getting used by DOMDocument, which I can only think is because it doesn't account for redirects, or the recieving server is blocking the request.

Having the full html response (from Guzzle) would have also helped determine the filesize a bit more accurately than just looking for the Content-Length header. At the moment there are a number of http requests not returning the Content-Length header.

Adding in some better error reporting would also have been a nice to have feature. At the moment I'm just skipping over failing http requests.