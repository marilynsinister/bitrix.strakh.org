<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Context,
	Bitrix\Main\Request;
use Bitrix\Main\Loader;

Loader::IncludeModule('highloadblock');

$context = Context::getCurrent();
$server = $context->getServer();

if($server->get('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest') {

	$request = $context->getRequest();

	if ($request->getPost("action") == "setComplete") {

		if ($request->getPost("crc") == md5($request->getPost("item") . 'bitrix')) {

			if (!empty($request->getPost("item"))) {

				$id = intval($request->getPost("item"));

				if ($id > 0){

					CBitrixComponent::includeComponentClass("smg:task.list");

					$obj = new CTaskManager(false, 1);
					$data = $obj->setComplete($id);

					if ($data){
						echo '1';
					}
					else{
						echo '0';
					}

				}

			}
		}
	}

	if ($request->getPost("action") == "setInactive") {

		if ($request->getPost("crc") == md5($request->getPost("item") . 'bitrix')) {

			if (!empty($request->getPost("item"))) {

				$id = intval($request->getPost("item"));

				if ($id > 0){

					CBitrixComponent::includeComponentClass("smg:task.list");

					$obj = new CTaskManager(false, 1);
					$data = $obj->setInactive($id);

					if ($data){
						echo '1';
					}
					else{
						echo '0';
					}

				}

			}
		}
	}
}
