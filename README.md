# Styla Spryker Module

This module provides integration with Styla content management system. It embeds Styla content on your Spryker (via JS), takes care of routing for it and server-side rendering of HTML tags. 

You can read more about Styla itself here: https://styladocs.atlassian.net/wiki/spaces/CO/pages/9961481/Technical+Integration

## Installation

The Styla spryker module can be added to your spryker shop via composer:

```
composer require styladev/spryker-plugin
```

## Configuration

Add the `Styladev` namespace to the spryker known namespaces:

```
$config[KernelConstants::CORE_NAMESPACES] = [
    'SprykerShop',
    'SprykerEco',
    'Spryker',
    'SprykerSdk',
    'Styladev'
];
```

Within the Spryker configuration for each locale the Styla client (you get it after signing contract) and additional the paths on which the styla integration should be displayed needs to be configured. The default configuration can be added to `config_default.php` and overridable with the more specific locale variants for example `config_default_DE.php`. 

The configuration should look like this:

```
$config[StylaConstants::CLIENT] = 'spryker-test';
$config[StylaConstants::PATHS] = 'inspiration/.*';
```

The paths are always from the root path (e.g. after domain) and can contain a pipe separated list. Wildcards needs to be flagged with an additional `/.*`.

For example if you have these list of pages:

```
/inspiration/my-page1
/inspiration/my-page1
/my-world
/magazine
/magazine/category/summer
/magazine/my-summer-story
```

the path configuration should look like:

```
$config[StylaConstants::CLIENT] = 'spryker-test';
$config[StylaConstants::PATHS] = 'inspiration/.*|my-world|magazine.*';
```

In this case `/inspiration` and `/magazine` are wildcard urls and `/my-world` is a single page without a wildcard.

You can have Styla content on different path for each locale, for instance use `/magazine` for English and `/magazin` for German. 

If you want to use your products in your Styla content, we will source it from your Spryker's Glue API. It needs to be configured on your end. 
