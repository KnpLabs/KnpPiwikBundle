Provides support for Piwik API into your Symfony2 projects.

## Installation

### Add Knplabs\PiwikClient to vendors

    git submodule add git://github.com/knplabs/PiwikClient.git src/vendor/PiwikClient

### Specify Knplabs\PiwikClient in autoload.php

    // src/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Knplabs\PiwikClient'   => $vendorDir.'/PiwikClient/src',
        // ...
    ));

### Add Knplabs\PiwikBundle to your src/Bundle dir

    git submodule add git://github.com/knplabs/PiwikBundle.git src/Bundle/Knplabs/KnplabsPiwikBundle

### Add KnplabsPiwikBundle to your application kernel

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Bundle\Knplabs\PiwikBundle\KnplabsPiwikBundle(),
            // ...
        );
    }

### Turn on piwik bundle in application config

    # app/config/config.yml
    piwik.config: ~

## Configuration

### HTTP client (Piwik on remote server)

    # app/config/config.yml
    piwik.config:
        connection: piwik.connection.http
        url:        http://piwik.example.com
        token:      PIWIK_API_TOKEN

### Local PHP client (Piwik on local server)

    # app/config/config.yml
    piwik.config:
        connection: piwik.connection.piwik
        token:      PIWIK_API_TOKEN

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

