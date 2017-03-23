# TYPO3 CMS skeleton project (using git-push deployment)

## Installation

```sh
composer create-project --keep-vcs bnf/typo3-project-template:dev-master foo-project
cd foo-project/
# TODO: change vendor name in composer.json
git rm README.md && git add composer.lock && git commit -m "Initialize foo-project"
vendor/bin/typo3cms install:setup --site-setup-type=site --site-name "Foo Site"
# do not store DB credentials in GIT
./vendor/bin/typo3cms configuration:remove --force DB/Connections/Default/user
./vendor/bin/typo3cms configuration:remove --force DB/Connections/Default/password
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
# Set to your servers hostname and path
REMOTE_HOST=user@remotehost
REMOTE_PATH=path/to/root
REMOTE_DB=whatever_prod

ssh $REMOTE_HOST "mkdir -p $REMOTE_PATH && git init --bare $REMOTE_PATH/repo && curl -s https://raw.githubusercontent.com/bnf/giddyup/master/update-hook > $REMOTE_PATH/repo/hooks/update && chmod +x $REMOTE_PATH/repo/hooks/update"
git remote add production $REMOTE_HOST:$REMOTE_PATH/repo

# Upload shared content
rsync  -az -e ssh --verbose --include 'web/' --include 'web/fileadmin/***' --include='web/uploads/***' --include='web/typo3conf/' --include='web/typo3conf/l10n/' --include='web/typo3conf/l10n/***'  --exclude='*' ./ $REMOTE_HOST:$REMOTE_PATH/shared/

# Upload database
./vendor/bin/typo3cms database:export | ssh $REMOTE_HOST "mysql $REMOTE_DB"

# Initial code upload
git push production
```

Now point your webserver's document root to $REMOTE\_PATH/current/web and from now on deploy with:

```sh
git push production
```

## TODO

Consider not clearing apcu/opcache caches but suggest to use realpath on the
webserver docroot to make the racy opcache/apcu/realpath cache clearing unnecessary.

See:

 - http://www.serverphorums.com/read.php?7,1233612,1233732#msg-1233732
 - https://codeascraft.com/2013/07/01/atomic-deploys-at-etsy/
