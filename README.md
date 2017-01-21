# TYPO3 CMS skeleton project (using git-push deployment)

## Installation

```sh
composer create-project bnf/typo3-project-template:dev-master foo-project --keep-vcs
cd foo-project/
# TODO: change vendor name in composer.json
git rm README.md && git add composer.lock && git commit -m "Initialize foo-project"
vendor/bin/typo3cms install:setup --site-setup-type=site --site-name "Foo Site"
php -S 127.0.0.1:3000 -t web
xdg-open http://127.0.0.1:3000/typo3
```

## Deployment setup

Deployment uses (a fork) of giddyup, a simple script that does fast
and reliable deployment in a git hook (features symlink rotation and shared directories).

```sh
# Set to your servers hostname and path
export REMOTE_HOST=user@remotehost
export REMOTE_PATH=path/to/root

ssh $REMOTE_HOST "mkdir -p $REMOTE_PATH && git init --bare $REMOTE_PATH/repo && curl -s https://raw.githubusercontent.com/bnf/giddyup/master/update-hook > $REMOTE_PATH/repo/hooks/update && chmod +x $REMOTE_PATH/repo/hooks/update"
git remote add production $REMOTE_HOST:$REMOTE_PATH/repo

# Now let your production vhost point to $REMOTE_PATH/current/web
# TODO: initial upload of database, fileadmin/ and uploads/
```

and from now on deploy with:

```sh
git push production
```
