[![Latest Stable Version](https://img.shields.io/packagist/v/crazy-max/login-servers-enhanced.svg?style=flat-square)](https://packagist.org/packages/crazy-max/login-servers-enhanced)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.3.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/com/crazy-max/login-servers-enhanced/master.svg?style=flat-square)](https://travis-ci.com/crazy-max/login-servers-enhanced)
[![Code Quality](https://img.shields.io/codacy/grade/c8ce7e3c975b4d63a433272c0d11664d.svg?style=flat-square)](https://www.codacy.com/app/crazy-max/login-servers-enhanced)

# login-servers-enhanced

This plugin display a constant list of servers in login form.<br />
It's a fork of the official plugin [login-servers](https://raw.github.com/vrana/adminer/master/plugins/login-servers.php) for [Adminer](https://www.adminer.org/) with enhancements.<br />
Was created for the [Neard](https://github.com/crazy-max/neard) project.

## Features

* Ability to select a server with different driver.

## Installation

### Adminer

Copy `plugins/login-servers-enhanced.php` in the plugins folder.

### Composer

```bash
composer require crazy-max/login-servers-enhanced
```

And download the code:

```bash
composer install # or update
```

## Getting started

Follow the instructions on the [official plugins page](https://www.adminer.org/en/plugins/).<br />
Then just add `new AdminerLoginServersEnhanced` to the `$plugins` array :

```php
function adminer_object() {
    // required to run any plugin
    include_once "./plugins/plugin.php";
    
    // autoloader
    foreach (glob("plugins/*.php") as $filename) {
        include_once "./$filename";
    }
    
    $plugins = array(
        new AdminerLoginServersEnhanced(
            array(
                new AdminerLoginServerEnhanced('127.0.0.1:3306', 'MySQL port 3306', 'server'),
                new AdminerLoginServerEnhanced('127.0.0.1:3307', 'MariaDB port 3307', 'server'),
                new AdminerLoginServerEnhanced('127.0.0.1:5432', 'PostgreSQL port 5432', 'pgsql')
            )
        )
    );
    
    /* It is possible to combine customization and plugins:
    class AdminerCustomization extends AdminerPlugin {
    }
    return new AdminerCustomization($plugins);
    */
    
    return new AdminerPlugin($plugins);
}

// include original Adminer or Adminer Editor
include "./adminer.php";
```

## License

Apache-2.0. See `LICENSE` for more details.
