# Styla Spryker Module

This module provides integration with STYLA content management system.

## Installation

The Styla spryker module can be added to your spryker shop via composer:

```
composer require styladev/spryker-plugin
```

## Configuration

Within the spryker configuration for each locale the styla client and additional the paths on which the styla integration should be displayed needs to be configured. The default configuration can be added to `config_default.php` and overridable with the more specific locale variants for example `config_default_DE.php`. 

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
