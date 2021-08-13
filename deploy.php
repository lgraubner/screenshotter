<?php
namespace Deployer;

require 'recipe/symfony.php';

set('application', 'screenshotter');

set('repository', 'git@github.com:lgraubner/screenshotter.git');

add('shared_dirs', ['var']);

host('168.119.227.77')
    ->user('deploy')
    ->set('deploy_path', '/var/www/{{application}}');
