# nastoletni/code

[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![StyleCI][ico-styleci]][link-styleci]

This is open source pastebin-like website with features like multifiles pastes and drag'n'drop. Every paste is not public. Access to this has only the one with link to it which is unique and generated from almost one trilion combinations.

This is created with developers in mind. If you have any idea that you would like to be implemented, create new issue and describe what you want. Any kind of feedback is welcome!

## Installation

1. Download Composer dependencies `composer install`
2. Install npm dependencies and compile sass `npm install && gulp`
3. Create config file with `cp src/config.yml.example src/config.yml` and fill it.
3. Populate database with schema from *schema.sql*

That's it.

[ico-travis]: https://img.shields.io/travis/nastoletni/code/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/nastoletni/code.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nastoletni/code.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/92681743/shield?branch=master

[link-travis]: https://travis-ci.org/nastoletni/code
[link-scrutinizer]: https://scrutinizer-ci.com/g/nastoletni/code/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nastoletni/code
[link-styleci]: https://styleci.io/repos/92681743
