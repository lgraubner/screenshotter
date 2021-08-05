<?php
namespace Deployer;

require 'recipe/symfony.php';

// Project name
set('application', 'screenshotter');

// Project repository
set('repository', 'git@github.com:lgraubner/screenshotter.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', ['.env', '.env.local']);
add('shared_dirs', ['var']);

// Writable dirs by web server
add('writable_dirs', ['var']);
set('allow_anonymous_stats', false);

// Hosts

host('168.119.227.77')
    ->user('root')
    ->set('deploy_path', '/var/www/{{application}}');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

// before('deploy:symlink', 'database:migrate');

