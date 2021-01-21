<?php
require '../vendor/autoload.php';

use Mia\PushBullet\PushBulletHelper;

$service = new PushBulletHelper('client_id', 'client_secret', 'client_iden');
$service->setAccessToken('user_token');
var_dump($service->getCurrentUser()->get);
exit();