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

use W7\App;
use function GuzzleHttp\Psr7\build_query;

\W7\Core\Facades\Router::any('/oauth/login', function () {
	$request = App::getApp()->getContext()->getRequest();
	$query = $request->getQueryParams();

	return \W7\Core\Facades\Context::getResponse()->redirect(ienv('API_HOST') . 'login?' . build_query($query));
});

//获取验证码
\W7\Core\Facades\Router::post('/common/verifycode/image', 'Common\VerifyCodeController@image');

//登录退出
\W7\Core\Facades\Router::post('/common/auth/login', 'Common\AuthController@login');
\W7\Core\Facades\Router::post('/common/auth/method', 'Common\AuthController@method');

\W7\Core\Facades\Router::get('/common/auth/getlogouturl', 'Common\AuthController@getlogouturl');
\W7\Core\Facades\Router::get('/common/auth/logout', 'Common\AuthController@logout');
\W7\Core\Facades\Router::post('/common/auth/logout', 'Common\AuthController@logout');
\W7\Core\Facades\Router::middleware('CheckAuthMiddleware')
	->post('/common/auth/user', 'Common\AuthController@user');

\W7\Core\Facades\Router::post('/common/auth/third-party-login', 'Common\AuthController@thirdPartyLogin');
\W7\Core\Facades\Router::post('/common/auth/third-party-login-bind', 'Common\AuthController@thirdPartyLoginBind');
\W7\Core\Facades\Router::post('/common/auth/default-login-url', 'Common\AuthController@defaultLoginUrl');

\W7\Core\Facades\Router::post('/menu/setting', 'Common\MenuController@setting');
