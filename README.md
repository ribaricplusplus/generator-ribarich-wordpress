# Generator Ribarich WordPress

Generate a WordPress plugin or theme

Tutorial about how to use the code scaffolded by this generator: https://www.youtube.com/watch?v=a-S6bYo0kT0

## Installation

First, install [Yeoman](http://yeoman.io) and generator-ribarich-wordpress using [npm](https://www.npmjs.com/) (we assume you have pre-installed [node.js](https://nodejs.org/)).

```bash
npm install -g yo
npm install -g generator-ribarich-wordpress
```

Then generate your new project:

```bash
yo ribarich-wordpress
```

## Notes and troubleshooting

This generator is optimized to work with LocalWP.

When running tests, you need to run the `npm run test-phpunit` from the shell launched by LocalWP, because it will contain all the required PHP extensions.

Furthermore, tests copy all database tables which sometimes results in an error due to MySQL sql_mode config variable. So if you're using LocalWP you need to change `sql_mode` in `conf/mysql/my.cnf.hbs`:

```
sql_mode = ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION
```

Copying tables slows down test execution, so you can set the environment variable `_PHPUNIT_SKIP_TABLE_COPYING=1` to skip this after the tables have already been copied once.

## Development

Get started with developing this generator.

- Clone the repository
- npm install
- npm link
- yo ribarich-wordpress => Runs the generator as it is in its current state. Make sure that any global version of the generator from npm is uninstalled.

## License

MIT © [Bruno Ribaric](https://ribarich.me/)


[npm-image]: https://badge.fury.io/js/generator-ribarich-wordpress.svg
[npm-url]: https://npmjs.org/package/generator-ribarich-wordpress
