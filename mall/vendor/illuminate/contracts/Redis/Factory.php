<?php

namespace Illuminate\Contracts\Redis;

interface Factory
{
	public function connection($name = NULL);
}


?>
