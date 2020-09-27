<?php

namespace W7\App\Provider\Socialite;

use Overtrue\Socialite\SocialiteManager;
use Symfony\Component\Finder\Finder;
use W7\Core\Facades\Config;
use W7\Core\Facades\Container;
use W7\Core\Provider\ProviderAbstract;

class ServiceProvider extends ProviderAbstract
{
	public function register()
	{
		$this->registerSocialiteManager();
		$this->registerThirdPartyLogin();
	}

	private function registerSocialiteManager()
	{
		Container::set(SocialiteManager::class, function() {
			return new SocialiteManager([]);
		});
	}

	private function registerThirdPartyLogin()
	{
		$thirdPartyLogins = [];
		foreach ((new Finder)->in(__DIR__ . '/ThirdPartyLogin/')->files() as $file) {
			if ($file->getExtension() !== 'php') {
				continue;
			}

			if (strrchr($file->getFilename(), 'Trait') === false) {
				$fileName = substr($file->getBasename(), 0, -4);
				$thirdPartyLogins[] = '\\W7\\App\\Provider\\Socialite\\ThirdPartyLogin\\' . $fileName;
			}
		}

		/**
		 * @var SocialiteManager $socialite
		 */
		$socialite = Container::get(SocialiteManager::class);
		foreach ($thirdPartyLogins as $name => $thirdPartyLogin) {
			$obj = new $thirdPartyLogin($socialite->getRequest(), '', '', '');
			$appId = $obj->getAppUnionId();
			$socialite->extend($appId, function ($config) use ($socialite, $thirdPartyLogin, $appId) {
				$redirectUrl = empty($config['redirect_url']) ? Config::get('common.api_host') . 'login?app_id=' . $appId : $config['redirect_url'];
				return new $thirdPartyLogin(
					$socialite->getRequest(),
					$config['client_id'],
					$config['client_secret'],
					$redirectUrl
				);
			});
		}
	}
}