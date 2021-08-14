<?php
namespace Deployer;

require 'recipe/symfony4.php';

set('bin_dir', 'bin');
set('var_dir', 'var');

// Project name
set('application', 'screenshotter');

// Project repository
set('repository', 'git@github.com:lgraubner/screenshotter.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);
set('ssh_multiplexing', false);

// Shared files/dirs between deploys
add('shared_files', ['var/app.db']);
add('shared_dirs', ['var/screenshots']);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

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

