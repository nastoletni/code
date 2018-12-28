# nastoletni/code

[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![StyleCI][ico-styleci]][link-styleci]

#### Visit [code.nastoletni.pl](https://code.nastoletni.pl/) and create your own paste!

This is open source pastebin-like website with features like multifile pastes and drag'n'drop. It keeps privacy of pastes, each file is being encrypted using AES-256-CBC and the only person (*or computer*) that knows the key is you.

We aim with this tool mainly for developers in mind and we want to keep it as usable and simple in use as we can. If you have any idea that could be implemented, [create a new issue](https://github.com/nastoletni/code/issues/new) and describe it. Any kind of feedback is welcome!

![Website look](/images/website_look.png)

## Install

1. Download Composer dependencies `composer install`
2. Install npm dependencies and compile sass `npm install && gulp`
3. Create config file with `cp src/config.yml.example src/config.yml` and fill it.
3. Populate database with schema from *schema.sql*

That's it.

## Security

If you discover any security related issues, please email [w.albert221@gmail.com](mailto:w.albert221@gmail.com) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/nastoletni/code/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/nastoletni/code.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nastoletni/code.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/92681743/shield?branch=master

[link-travis]: https://travis-ci.org/nastoletni/code
[link-scrutinizer]: https://scrutinizer-ci.com/g/nastoletni/code/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nastoletni/code
[link-styleci]: https://styleci.io/repos/92681743
