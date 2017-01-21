# TYPO3 CMS skeleton project (using git-push deployment)

## Installation

```sh
composer create-project bnf/typo3-project:dev-master foo-project
cd foo-project/
git rm README.md && git commit -m "Remove README.md from template"
vendor/bin/typo3cms install:setup --site-setup-type=site --site-name "Foo Site"
php -S 127.0.0.1:8888 -t web
xdg-open https://127.0.0.1:8888/typo3
```
