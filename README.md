### Setup

```sh
$ composer install
$ npm install
```

and change virtual url on gulpfile.js

### Available CLI commands

- `composer lint:wpcs` : checks all PHP files against [PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- `composer lint:php` : checks all PHP files for syntax errors.
- `composer make-pot` : generates a .pot file in the `languages/` directory.
- `npm run bundle` : gulp build and generates a .zip archive for distribution, excluding development and system files.

- `gulp watch` : start 
- `gulp` : commands...