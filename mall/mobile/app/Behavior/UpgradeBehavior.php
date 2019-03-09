<?php

namespace App\Behavior;

class UpgradeBehavior
{
	private $store;

	public function run()
	{
		$release = ROOT_PATH . 'storage/logs/.' . RELEASE;

		if (!file_exists($release)) {
			$this->store = new \App\Patches\Factory\Store();
			$this->store->run();
			require ROOT_PATH . 'storage/clean.php';
			file_put_contents($release, VERSION);
		}
	}
}


?>
