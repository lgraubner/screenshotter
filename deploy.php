<?php
namespace Deployer;

require 'recipe/symfony.php';

set('application', 'screenshotter');

set('repository', 'git@github.com:lgraubner/screenshotter.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

add('shared_dirs', ['var']);

host('168.119.227.77')
    ->user('deploy')
    ->set('deploy_path', '/var/www/{{application}}');

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

// before('deploy:symlink', 'database:migrate');

