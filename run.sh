 ./vendor/bin/phpunit  tests\ExampleTests.php
php -S localhost:8080

./vendor/bin/phpunit --coverage-html coverage --coverage-filter src
