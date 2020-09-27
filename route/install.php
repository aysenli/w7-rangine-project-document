<?php

/**
 * WeEngine Document System
 *
 * (c) We7Team 2019 <https://www.w7.cc>
 *
 * This is not a free software
 * Using it under the license terms
 * visited https://www.w7.cc for more details
 */

\W7\Core\Facades\Router::post('/install/systemDetection', 'Install\IndexController@systemDetection');
\W7\Core\Facades\Router::post('/install/install', 'Install\IndexController@install');
\W7\Core\Facades\Router::post('/install/config', 'Install\IndexController@config');
