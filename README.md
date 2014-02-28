## Not actively maintained

This project is not actively maintained by KnpLabs. Please contact us if you would like to take over.

Provides support for Piwik API into your Symfony2 projects.

## Installation

### Add Knp\PiwikClient to vendors

    git submodule add git://github.com/KnpLabs/KnpPiwikClient.git vendor/PiwikClient

### Specify Knp\PiwikClient in autoload.php

    // app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Knp\PiwikClient'   => __DIR__.'/../vendor/PiwikClient/src',
        // ...
    ));

### Add Knp\PiwikBundle to your src/Bundle dir

    git submodule add git://github.com/KnpLabs/PiwikBundle.git vendor/bundles/Knp/Bundle/PiwikBundle

### Add KnpPiwikBundle to your application kernel

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Knp\Bundle\PiwikBundle\KnpPiwikBundle(),
            // ...
        );
    }

## Configuration

### HTTP client (Piwik on remote server)

    # app/config/config.yml
    knp_piwik:
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
    knp_piwik:
        connection: piwik.connection.piwik
        token:      PIWIK_API_TOKEN

You need to require Piwik library in autoload.php:

    // src/autoload.php
    // ...
    define('PIWIK_ENABLE_DISPATCH', false);
    define('PIWIK_ENABLE_ERROR_HANDLER', false);
    define('PIWIK_ENABLE_SESSION_START', false);
    require_once PIWIK_INCLUDE_PATH . "/index.php";
    require_once PIWIK_INCLUDE_PATH . "/core/API/Request.php";
    Piwik_FrontController::getInstance()->init();

### Testing

There is another connection, called stub. It's used for testing:

    # app/config/config_test.yml
    knp_piwik:
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

PiwikClient Copyright (c) 2011 KnpLabs <http://KnpLabs.com>. See LICENSE for details.
