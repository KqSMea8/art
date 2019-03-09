<?php
//艺术者  禁止倒卖 一经发现停止任何服务 QQ:123456
namespace App\Api\Transformers;

class UserTransformer extends \League\Fractal\TransformerAbstract
{
	public function transform(\App\Models\Users $user)
	{
		return array('id' => $user->user_id, 'name' => $user->user_name);
	}
}

?>
