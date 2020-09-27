<?php

return [
	'database' => [
		'default_database_name' => ienv('DATABASE_DEFAULT_DATABASE'),
		'host' => ienv('DATABASE_ORIGINAL_HOST'),
		'username' => ienv('DATABASE_ORIGINAL_USERNAME'),
		'password' => ienv('DATABASE_ORIGINAL_PASSWORD'),
		'database' => ienv('DATABASE_ORIGINAL_DATABASE'),
	]
];