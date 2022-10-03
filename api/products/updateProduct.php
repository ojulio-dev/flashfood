<?php

$data = json_decode(file_get_contents('php://input'), true);
print_r($data);

var_dump($data['banner']);