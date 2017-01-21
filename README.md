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

## Deployment setup

Deployment uses (a fork) of giddyup, a simple script that does fast
and reliable deployment in a git hook (features symlink rotation and shared directories).

```sh
# Set to your servers hostname and path
export REMOTE_HOST=user@remotehost
export REMOTE_PATH=path/to/root

ssh $REMOTE_HOST "mkdir -p $REMOTE_PATH && git init --bare $REMOTE_PATH/repo && curl -s https://raw.githubusercontent.com/bnf/giddyup/master/update-hook > $REMOTE_PATH/repo/hooks/update && chmod +x $REMOTE_PATH/repo/hooks/update"
git remote add live $REMOTE_HOST:$REMOTE_PATH/repo
```

and from now on deploy with:

```sh
git push live
```
