<?php

namespace App\Modules\Api\Foundation;

class Controller extends \App\Modules\Base\Controllers\FrontendController
{
	protected function apiReturn($data, $code = 0)
	{
		$this->response(array('code' => $code, 'data' => $data));
	}

	protected function validate($args, $pattern)
	{
		$validator = Validation::createValidation();
		$rules = Validation::transPattern($pattern);

		if ($validator->validate($rules)->create($args) === false) {
			return $validator->getError();
		}
		else {
			return true;
		}
	}
}

?>
