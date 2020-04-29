<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\SystemException,
 	Bitrix\Main\Loader,
 	Bitrix\Main\Type\Date,

	Bitrix\Highloadblock as HL,
	Bitrix\Main\Entity,

	Bitrix\Main\Context,
	Bitrix\Main\Request;

class CTaskManagerNew extends CBitrixComponent
{


	protected function add(&$data_post)
	{
		if ($this->errors)
			throw new SystemException(current($this->errors));

		$additionalCacheID = false;

		$hlbl = 1; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
		$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

		$entity = HL\HighloadBlockTable::compileEntity($hlblock);

		$entity_data_class = $entity->getDataClass();

		// Массив полей для добавления
		$data = array(
			"UF_NAME"		 	=> $data_post['name'],
			"UF_DATETIME" 		=> $data_post['datetime'],
			"UF_STATUS"			=> 1,
			"UF_ACTIVE"			=> 1,
			"UF_COMMENT" 		=> $data_post['comment'],
		);
//dz($data_post['name']);
		$result = $entity_data_class::add($data);
		//dz($result);
		if ($result) LocalRedirect("/?success_at=1");

	}

	protected function checkModules()
	{
		if (!Loader::includeModule('iblock'))
		{
			ShowError(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
			return;
		}

		if (!Loader::includeModule("highloadblock")){
			//ShowError(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
			return;
		}

	}

	public function executeComponent()
	{
		try
		{
			$this->checkModules();

			$context = Context::getCurrent();
			$request = $context->getRequest();

			if ($request->getPost("submit") == 1) {
				dz('1');
				$this->add($request->getPostList());
			}
			$this->includeComponentTemplate();
		}
		catch (SystemException $e)
		{
			ShowError($e->getMessage());
		}
	}
}?>