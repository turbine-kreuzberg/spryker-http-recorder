include makefiles/help.mk

setup: ##@setup install dependencies
	make install-git-hooks
	docker-compose up -d
.PHONY: setup

tests: ##@development run tests
	docker-compose exec -T php vendor/bin/phpunit --colors=always -c tests/phpunit.xml
.PHONY: tests

test-coverage: ##@development run tests
	docker-compose exec -T php vendor/bin/phpunit --colors=always -c phpunit.xml --coverage-text --coverage-html=tests/_output
.PHONY: test-coverage

phpstan: ##@development run phpstan
	docker-compose exec -T php vendor/bin/phpstan analyse
.PHONY: phpstan

sniff-project: ##@development run code sniffer
	docker-compose exec -T php vendor/bin/phpcs src/ tests/ --standard=./config/codesniffer_ruleset.xml
.PHONY: sniff-project

sniff-fix-project: ##@development run code sniffer
	docker-compose exec -T php vendor/bin/phpcbf src/ tests/ --standard=./config/codesniffer_ruleset.xml
.PHONY: sniff-fix-project

install-git-hooks: ##@development install git hooks
	git config core.hooksPath .githooks
.PHONY: install-git-hooks-include

%:
	@:
