<a href="https://aimeos.org/">
    <img src="https://aimeos.org/fileadmin/template/icons/logo.png" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# Aimeos online shop distribution for TYPO3

The distribution package provides an out of the box web shop based on the the Aimeos
online shop extension for TYPO3. The package contains a pre-configured, full featured shop
including faceted search, product listings and detail views as well as baskets, coupon
handling the checkout process and all e-mail handling for notifying the customers.

**Table of contents**
- [Installation](#installation)
    - [Composer](#composer)
    - [From TER](#from-ter)
- [Test](#test)
- [License](#license)
- [Links](#links)

## Installation

### Composer

**Note:** You need *composer 2.2+* to install the latest version of Aimeos.

To install TYPO3 via composer, execute this at the command line

```bash
wget https://getcomposer.org/download/latest-stable/composer.phar -O composer
php composer create-project "typo3/cms-base-distribution:^14.3" myshop
```

You can also use `"typo3/cms-base-distribution:^13.4"` for TYPO3 13 installations.

Set up your TYPO3 installation by executing this command:

```bash
./vendor/bin/typo3 setup
```

Now install the Aimeos distribution for TYPO3 via command line:

```bash
composer req -W aimeos/aimeos_dist
```

Then, activate the extensions and update the database:

```bash
./vendor/bin/typo3 extension:setup
./vendor/bin/typo3 aimeos:setup --option=setup/default/demo:1
```

If you don't want to import the demo data, leave out `--option=setup/default/demo:1`.
Afterwards, your Aimeos installation is complete and you can check the frontend and
log into the TYPO3 backend.

### From TER

For non-composer installations, you can install the Aimeos distribution using the
Extension manager. You can choose Aimeos from the list of available distributions:

![TYPO3 distributions](https://aimeos.org/fileadmin/aimeos.org/images/aimeos-typo3-dist-install.png)

Alternatively, you can download the [Aimeos TYPO3 distribution](https://extensions.typo3.org/extension/aimeos_dist/)
package from the TER.

## Test

For local installations, you can fire up the internal PHP web server

```bash
php -d memory_limit=256M -d max_execution_time=240 -d max_input_vars=1500 -S 127.0.0.1:8000 -t public
```

and open the URL ("http://127.0.0.1:8000") in your web browser. If you use Apache or
another web server, head over directly to the URL your installation is reachable directly
without starting the PHP wev server. Complete the TYPO3 setup process before you continue
to install the Aimeos distribution.

## License

The Aimeos TYPO3 distribution is licensed under the terms of the GPL Open Source
license and is available for free.

## Links

* [Web site](https://aimeos.org/TYPO3)
* [Help](https://aimeos.org/help)
* [Documentation](https://aimeos.org/docs/typo3/)
* [Issue tracker](https://github.com/aimeos/aimeos-typo3-dist/issues)
* [Source code](https://github.com/aimeos/aimeos-typo3-dist)
