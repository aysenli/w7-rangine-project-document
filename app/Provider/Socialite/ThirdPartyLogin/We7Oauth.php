<?php

namespace W7\App\Provider\Socialite\ThirdPartyLogin;

use GuzzleHttp\Client;
use Overtrue\Socialite\ProviderInterface;
use Overtrue\Socialite\Providers\AbstractProvider;
use Overtrue\Socialite\AccessTokenInterface;
use W7\Core\Facades\Config;
use W7\Http\Message\Server\Response;

class We7Oauth extends AbstractProvider implements ProviderInterface
{
	use OauthTrait;

	public function getAppUnionId()
	{
		return '3';
	}

	protected function getAuthUrl($state)
	{
		$data = [
			'redirect' => $this->redirectUrl,
			'appid' => $this->clientId
		];

		$headers = [];
		if (Config::get('common.request_user_agent')) {
			$headers['User-Agent'] = Config::get('common.request_user_agent');
		}
		$response = (new Client())->post('http://api.w7.cc/oauth/login-url/index', [
			'form_params' => $data,
			'headers' => $headers
		]);

		$result = $response->getBody()->getContents();
		if (empty($result)) {
			throw new \RuntimeException('获取授权地址错误');
		}

		$result = json_decode($result, true);
		if (!empty($result['error'])) {
			throw new \RuntimeException($result['error']);
		}

		return $result['url'];
	}

	/**
	 * Get the Post fields for the token request.
	 *
	 * @param string $code
	 *
	 * @return array
	 */
	protected function getTokenFields($code)
	{
		return [
			'code' => $code
		];
	}

	/**
	 * Get the access token for the given code.
	 *
	 * @param string $code
	 *
	 * @return \Overtrue\Socialite\AccessToken
	 */
	public function getAccessToken($code)
	{
		$response = $this->getHttpClient()->post($this->getTokenUrl(), [
			'form_params' => $this->getTokenFields($code),
		]);

		$data = \json_decode($response->getBody()->getContents(), true);
		$data['access_token'] = $data['accessToken'];
		return $this->parseAccessToken(\json_encode($data));
	}

	/**
	 * Get the raw user for the given access token.
	 * @param AccessTokenInterface $token
	 * @return mixed
	 */
	protected function getUserByToken(AccessTokenInterface $token)
	{
		$data = [
			'access_token' => $token->getToken()
		];

		$response = $this->getHttpClient()->post($this->getUserInfoUrl(), [
			'form_params' => $data
		]);

		return \json_decode($response->getBody()->getContents(), true);
	}

	public function logout(Response $psrResponse): Response
	{
		$data = [
			'redirect_url' => Config::get('common.api_host') . 'admin-login'
		];

		$headers = [];
		if (Config::get('common.request_user_agent')) {
			$headers['User-Agent'] = Config::get('common.request_user_agent');
		}
		$response = (new Client())->post('http://api.w7.cc/oauth/logout-url/index', [
			'form_params' => $data,
			'headers' => $headers
		]);

		$result = $response->getBody()->getContents();
		if (empty($result)) {
			throw new \RuntimeException('获取退出授权地址错误');
		}

		$result = json_decode($result, true);
		if (!empty($result['error'])) {
			throw new \RuntimeException($result['error']);
		}

		return $psrResponse->redirect($result['url']);
	}
}
