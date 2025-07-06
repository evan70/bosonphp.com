## Installation

1. `docker compose up --build -d`
2. `make php`
3. `composer db:up`
4. `composer db:fill -- -q` (fixtures, optional)

## Other Commands

- `composer linter` - Run static analyzer
- `composer linter:baseline` - (Re-)Generate linter baseline
- `composer phpcs:fix` - Fix codestyle issues
- `composer db:up` - Apply migrations
- `composer db:down` - Rollback migrations
- `composer db:refresh` - Refresh all migrations
- `composer db:diff` - Generate migrations
- `composer test` - Run all tests
- `composer test:unit` - Run unit tests
- `composer test:feature` - Run functional tests
