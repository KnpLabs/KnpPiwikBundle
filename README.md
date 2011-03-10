Provides support for Piwik API into your Symfony2 projects.

## Installation

### Add Knplabs\PiwikClient to vendors

    git submodule add git://github.com/knplabs/PiwikClient.git vendor/PiwikClient

### Specify Knplabs\PiwikClient in autoload.php

    // app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Knplabs\PiwikClient'   => __DIR__.'/../vendor/PiwikClient/src',
        // ...
    ));

### Add Knplabs\PiwikBundle to your src/Bundle dir

    git submodule add git://github.com/knplabs/PiwikBundle.git vendor/bundles/Knplabs/Bundle/PiwikBundle

### Add KnplabsPiwikBundle to your application kernel

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Knplabs\Bundle\PiwikBundle\KnplabsPiwikBundle(),
            // ...
        );
    }

### Turn on piwik bundle in application config

    # app/config/config.yml
    knplabs_piwik:  ~

## Configuration

### HTTP client (Piwik on remote server)

    # app/config/config.yml
    knplabs_piwik:
        connection: piwik.connection.http
        url:        http://piwik.example.com
        token:      PIWIK_API_TOKEN

Don't forget to add Buzz library for HTTP requests into vendors:

    git submodule add https://github.com/kriswallsmith/Buzz.git src/vendor/Buzz

And to autoload.php:

    // src/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Buzz'  => $vendorDir.'/Buzz/lib',
        // ...
    ));

### Local PHP client (Piwik on local server)

    # app/config/config_dev.yml
    knplabs_piwik:
        connection: piwik.connection.piwik
        token:      PIWIK_API_TOKEN

You need to require Piwik library in autoload.php:

    // src/autoload.php
    // ...
    require_once PIWIK_INCLUDE_PATH . "/index.php";
    require_once PIWIK_INCLUDE_PATH . "/core/API/Request.php";
    Piwik_FrontController::getInstance()->init();

### Testing

There is another connection, called stub. It's used for testing:

    # app/config/config_test.yml
    knplabs_piwik:
        connection: piwik.connection.stub

## Usage

In your controllers:

    $dataArray = $this->get('piwik.client')->
        call('API.getReportMetadata', array('idSites' => array(2, 3)));

Everywhere:

    $dataArray = $container->get('piwik.client')->
        call('API.getReportMetadata', array('idSites' => array(2, 3)));

### Api Calls

To see all available methods & their parameters, visit [Piwik API Reference](http://dev.piwik.org/trac/wiki/API/Reference).

## Copyright

PiwikClient Copyright (c) 2011 knpLabs <http://www.knplabs.com>. See LICENSE for details.
