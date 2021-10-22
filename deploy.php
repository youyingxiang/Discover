<?php

/*
 * // +----------------------------------------------------------------------
 * // | erp
 * // +----------------------------------------------------------------------
 * // | Copyright (c) 2006~2020 erp All rights reserved.
 * // +----------------------------------------------------------------------
 * // | Licensed ( LICENSE-1.0.0 )
 * // +----------------------------------------------------------------------
 * // | Author: yxx <1365831278@qq.com>
 * // +----------------------------------------------------------------------
 */

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'hzerp');

// Project repository
set('repository', 'git@gitee.com:yxx2017/hzerp.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

//set('default_stage', 'master');

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', ['public/uploads']);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);
set('writable_use_sudo', false);

// Hosts
set('keep_releases', 5);
set('default_stage', 'dev');

host('dev')
    ->stage('dev')
    ->hostname('118.178.125.242')
    ->user('deployer')
    // 并指定公钥的位置
    ->identityFile('~/.ssh/deployerkey')
    ->set('branch', 'master')
    ->set('http_user', 'nginx')
    ->forwardAgent(true)
    ->multiplexing(true)
    // 指定项目部署到服务器上的哪个目录
    ->set('deploy_path', '/data/wwwroot/erp');

host('yxx')
    ->stage('yxx')
    ->hostname('47.106.87.22')
    ->user('deployer')
    // 并指定公钥的位置
    ->identityFile('~/.ssh/deployerkey')
    ->set('branch', 'master')
    ->set('http_user', 'www-data')
    ->forwardAgent(true)
    ->multiplexing(true)
    // 指定项目部署到服务器上的哪个目录
    ->set('deploy_path', '/data/wwwroot/erp');

task('artisan:cache:clear', function () {
    return true;
});
task('artisan:config:cache', function () {
    return true;
});
task('artisan:route:cache', function () {
    return true;
});
task('artisan:view:cache', function () {
    return true;
});
task('opcache:reload', function () {
    cd('{{release_path}}');
    // run('{{bin/php}} artisan optimize && {{bin/composer}} dump-autoload --optimize && {{bin/php}} artisan config:clear');
    run('{{bin/php}} artisan optimize && {{bin/composer}} dump-autoload --optimize && {{bin/php}} artisan migrate && {{bin/php}} artisan db:seed --class=InitSeeder');
    $ret = (int) run('ps -ef |grep -w laravels|grep -v grep|wc -l');
    if ($ret > 0) {
        run('sudo {{bin/php}} bin/laravels restart -d 1>/dev/null');
    } else {
        run('sudo /usr/sbin/service php7.4-fpm reload');
    }
});
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'opcache:reload');
