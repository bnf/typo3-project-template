# TYPO3 CMS skeleton project (using git-push deployment)

## Installation

```sh
composer create-project --keep-vcs bnf/typo3-project-template:dev-master foo-project
cd foo-project/
composer config name your-vendor/foo-site-name
git rm README.md && git add composer.lock && git commit -m "Initialize foo-project"
vendor/bin/typo3cms install:setup --site-setup-type=site --site-name "Foo Site"
# Add LocalConfiguration.php to git
git add web/typo3conf/LocalConfiguration.php && git commit -m "Add initial configuration"

# prevent notice in install (that systemLocale is not set)
vendor/bin/typo3cms configuration:set SYS/UTF8filesystem true
vendor/bin/typo3cms configuration:set SYS/systemLocale de_DE.UTF-8
git commit -a -m "Enable UTF-8 filesystem"

# Now run a test server with
php -S 127.0.0.1:3000 -t web

# And open the TYPP3 backend in your browser
xdg-open http://127.0.0.1:3000/typo3
```

## Deployment setup

Deployment uses (a fork) of giddyup, a simple script that does fast
and reliable deployment in a git hook (features symlink rotation and shared directories).

```sh
composer config extra.remote.production ssh://user@host:22/absolute/path/to/root/repo
composer run-script init-production
```

Now point your webserver's document root to $REMOTE\_PATH/current/web and from now on deploy with:

```sh
git push production
```
