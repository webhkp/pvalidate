test:
	./vendor/bin/pest

coverage:
	# XDEBUG_MODE=coverage ./vendor/bin/pest --coverage
	./vendor/bin/pest --coverage