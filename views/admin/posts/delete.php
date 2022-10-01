<?php

use App\Table\PostTable;

$table = new PostTable();
$table->delete($params["id"]);

header("Location: " . $router->url("posts") . "?deleted=1");
http_response_code(301);