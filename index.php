<?php

$routes = [
    'register' => '/app/controllers/RegisterController.php',
    'login' => '/app/controllers/LoginController.php',
    'recordlist' => '/app/controllers/RecordListController.php',
    'addrecord' => '/app/controllers/AddRecordController.php',
    'editrecord' => '/app/controllers/EditRecordController.php',
    'bandlist' => '/app/controllers/BandListController.php',
    'addband' => '/app/controllers/AddBandController.php',
    'editband' => '/app/controllers/EditBandController.php',
    'albumlist' => '/app/controllers/AlbumListController.php'
];

$page = $_GET['page'] ?? 'login';

if (array_key_exists($page, $routes)) {
    require __DIR__ . $routes[$page];
} else {
    http_response_code(404);
    echo '404 Not Found';
}
