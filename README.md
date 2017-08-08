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

# Optional: In case you're using php-fpm with a custom socket path, configure the hook to use the correct fpm socket
ssh $REMOTE_HOST "git --git-dir=$REMOTE_PATH/repo config giddyup.fcgi-socket /run/php70-fpm-foo.sock"

# Upload shared content
rsync  -az -e ssh --verbose --include 'web/' --include 'web/fileadmin/***' --include='web/uploads/***' --exclude='*' ./ $REMOTE_HOST:$REMOTE_PATH/shared/

# Upload database
./vendor/bin/typo3cms database:export | ssh $REMOTE_HOST "mysql $REMOTE_DB"

# Initial code upload
git push production
```

Now point your webserver's document root to $REMOTE\_PATH/current/web and from now on deploy with:

```sh
git push production
```
