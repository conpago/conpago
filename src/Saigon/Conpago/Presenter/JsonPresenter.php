<?php
/**
 * Created by PhpStorm.
 * User: bg
 * Date: 13.05.14
 * Time: 21:57
 */

namespace Saigon\Conpago\Presenter;


use Saigon\Conpago\IJsonPresenter;

class JsonPresenter implements IJsonPresenter {

	function showJson($data)
	{
		echo json_encode($data, JSON_FORCE_OBJECT);
	}
}