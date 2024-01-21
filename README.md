## Basic:
Use cases: [QueryFormatterTest](tests/Query/QueryFormatterTest.php)
Main component: [QueryFormatter](src/QueryFormatter.php)
All implemented formatting strategies: [Formatters](/src/Query/Formatter)

## Dev tools usage:

run project:
```bash
docker compose up
```

install dependencies: 
```bash
docker compose exec app composer install
```

phpunit: 
```bash
docker compose exec app php vendor/bin/phpunit
```

phpstan:
```bash
docker compose exec app php vendor/bin/phpstan analyze src --level 9
```

run ecs: 
```bash
docker compose exec app php vendor/bin/ecs
```

## Overall project structure:

```
src
├── Query
│ ├── Formatter
│ │ ├── ArrayFormatter.php
│ │ ├── DecimalFormatter.php
│ │ ├── DefaultFormatter.php
│ │ ├── FloatFormatter.php
│ │ ├── Formatter.php
│ │ └── IdentifierFormatter.php
│ └── FormatterRegistry.php
└── QueryFormatter.php
```

```
tests
└── Query
    ├── Formatter
    │ ├── ArrayFormatterTest.php
    │ ├── DecimalFormatterTest.php
    │ ├── DefaultFormatterTest.php
    │ ├── FloatFormatterTest.php
    │ └── IdentifierFormatterTest.php
    └── QueryFormatterTest.php
```
