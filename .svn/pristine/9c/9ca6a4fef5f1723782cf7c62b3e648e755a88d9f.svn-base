<?php

namespace App\Modules\Api\Controllers;

class IndexController extends \App\Modules\Base\Controllers\FrontendController
{
	/** @var IndexService */
	private $indexService;

	public function __construct(\App\Services\IndexService $indexService)
	{
		$this->indexService = $indexService;
	}

	public function actionIndex()
	{
		$this->response(array('code' => 200, 'data' => 'api server.'));
	}

	public function actionHome()
	{
		$banners = $this->indexService->getBanners();
		$data['banner'] = $banners;
		$adsense = $this->indexService->getAdsense();
		$data['adsense'] = $adsense;
		$goodsList = $this->indexService->bestGoodsList();
		$data['goods_list'] = $goodsList;
		return $this->apiReturn($data);
	}
}

?>
