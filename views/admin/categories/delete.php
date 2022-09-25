<?php

use App\Table\CategoryTable;

$table = new CategoryTable();
$table->delete($params["id"]);

header("Location:" . $router->url("categories") . "?deleted=1");
http_response_code(301);