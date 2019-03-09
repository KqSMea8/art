<?php

namespace App\Contracts\Services;

interface ShopServiceInterface
{
	public function create();

	public function get();

	public function update();

	public function getStatus();

	public function search();

	public function createAddress();

	public function getAddress();

	public function updateAddress();

	public function deleteAddress();

	public function searchAddress();

	public function createStore();

	public function getStore();

	public function updateStore();

	public function deleteStore();

	public function searchStore();

	public function storeSetting();

	public function getStoreGoods();

	public function updateStoreGoods();

	public function uploadMaterials();
}


?>
