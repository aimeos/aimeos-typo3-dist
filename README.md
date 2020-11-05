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
    - [TYPO3 backend](#typo3-backend)
    - [Composer](#composer)
- [License](#license)
- [Links](#links)

## Installation

## TYPO3 backend

For non-composer installations, you can install the Aimeos distribution using the
Extension manager. You can choose Aimeos from the list of available distributions:

![TYPO3 distributions](https://aimeos.org/fileadmin/aimeos.org/images/aimeos-typo3-dist-install.png)

Alternatively, you can download the [Aimeos TYPO3 distribution](https://extensions.typo3.org/extension/aimeos_dist/)
package from the TER:

![TYPO3 extension repository:](https://aimeos.org/fileadmin/aimeos.org/images/aimeos-typo3-dist-install.png)

### Composer

If you have a composer based installation, you need to add this to your `composer.json`
file in the root application directory:

```json
    "scripts": {
        "post-install-cmd": [
            "Aimeos\\Aimeos\\Custom\\Composer::install"
        ],
        "post-update-cmd": [
            "Aimeos\\Aimeos\\Custom\\Composer::install"
        ],
        ...
}```

Then install the Aimeos distribution for TYPO3:

```bash
composer req aimeos/aimeos_dist
```

Finally, activate the extensions:

```bash
./vendor/bin/typo3 extension:activate aimeos
./vendor/bin/typo3 extension:activate aimeos_dist
```

## License

The Aimeos TYPO3 distribution is licensed under the terms of the GPL Open Source
license and is available for free.

## Links

* [Web site](https://aimeos.org/TYPO3)
* [Help](https://aimeos.org/help)
* [Documentation](https://aimeos.org/docs/typo3/)
* [Issue tracker](https://github.com/aimeos/aimeos-typo3-dist/issues)
* [Source code](https://github.com/aimeos/aimeos-typo3-dist)
