<?php

//$url = exec('git config remote.production.url');
$url = exec('composer config extra.remote.production');

$p = parse_url($url);

if (!isset($p['scheme']) || $p['scheme'] !== 'ssh' || !isset($p['host']) || !isset($p['path'])) {
    throw new Exception('Invalid SSH format. Use: composer config extra.remote.production ssh://user@host:22/absolute/path/to/root/repo');
}

if (basename($p['path']) != 'repo') {
    throw new Exception('Invalid SSH format. You directory name should include the git repo, e.g: composer config extra.remote.production ssh://user@host:22/absolute/path/to/root/repo');
}

$ssh_cmd = 'ssh' . (isset($p['port']) ? ' -p' . $p['port'] : '');
$user_host = (isset($p['user']) ? $p['user'] . '@' : '') . $p['host'];

printf(
    "%s %s 'mkdir -p %s && git init --bare %s && curl -s %s -o %s/hooks/update && chmod +x %s/hooks/update'\n",
    $ssh_cmd,
    $user_host,
    dirname($p['path']),
    $p['path'],
    'https://raw.githubusercontent.com/bnf/giddyup/master/update-hook',
    $p['path'],
    $p['path']
);

printf("rsync -e '%s' -avz --include 'web/' --include 'web/fileadmin/***' --include='web/uploads/***' --include='web/typo3conf/' --include='web/typo3conf/l10n/' --include='web/typo3conf/l10n/***'  --exclude='*' ./ %s:%s/shared/\n",
    $ssh_cmd, $user_host, dirname($p['path']));

printf("composer run-script git-setup\n");
printf("git push production HEAD:master\n");

#printf("./vendor/bin/typo3cms database:export | %s %s 'mysql \$REMOTE_DB'" . PHP_EOL, $ssh_cmd, $user_host);
printf("./vendor/bin/typo3cms database:export | %s %s '%s/vendor/bin/typo3cms database:import'\n", $ssh_cmd, $user_host, dirname($p['path']));
