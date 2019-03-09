<?php

namespace App\Services;

class ShopService implements \App\Contracts\Services\ShopServiceInterface
{
	/**
     * @var ShopRepository
     */
	private $shopRepository;

	public function __construct(\App\Repositories\Shop\ShopRepository $shopRepository)
	{
		$this->shopRepository = $shopRepository;
	}

	public function getShopName($ruId)
	{
		$shopInfo = $this->shopRepository->findBY('ru_id', $ruId);

		if (0 < count($shopInfo)) {
			$shopInfo = $shopInfo[0];

			if ($shopInfo['shopname_audit'] == 1) {
				if (0 < $ruId) {
					$shopName = $shopInfo['brandName'] . $shopInfo['shopNameSuffix'];
				}
				else {
					$shopName = $shopInfo['shop_name'];
				}
			}
			else {
				$shopName = $shopInfo['rz_shopName'];
			}
		}
		else {
			$shopName = '';
		}

		return $shopName;
	}

	public function create()
	{
	}

	public function get()
	{
	}

	public function update()
	{
	}

	public function getStatus()
	{
	}

	public function search()
	{
	}

	public function createAddress()
	{
	}

	public function getAddress()
	{
	}

	public function updateAddress()
	{
	}

	public function deleteAddress()
	{
	}

	public function searchAddress()
	{
	}

	public function createStore()
	{
	}

	public function getStore()
	{
	}

	public function updateStore()
	{
	}

	public function deleteStore()
	{
	}

	public function searchStore()
	{
	}

	public function storeSetting()
	{
	}

	public function getStoreGoods()
	{
	}

	public function updateStoreGoods()
	{
	}

	public function uploadMaterials()
	{
	}
}

?>
