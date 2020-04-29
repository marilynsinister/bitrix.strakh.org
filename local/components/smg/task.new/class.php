<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\SystemException,
 	Bitrix\Main\Loader,
 	Bitrix\Main\Type\Date,

	Bitrix\Highloadblock as HL,
	Bitrix\Main\Entity,

	Bitrix\Main\Context,
	Bitrix\Main\Request;

CBitrixComponent::includeComponentClass("smg:task.list");

class CTaskManagerNew extends CTaskManager
{


	protected function add(&$data_post)
	{
		if ($this->errors)
			throw new SystemException(current($this->errors));

		$entity_data_class = $this->entityClass;

		// Массив полей для добавления
		$data = array(
			"UF_NAME"		 	=> $data_post['name'],
			"UF_DATETIME" 		=> date($this->arParams['DATE_FORMAT'], time()),
			"UF_STATUS"			=> 1,
			"UF_ACTIVE"			=> 1,
			"UF_COMMENT" 		=> $data_post['comment'],
		);
		if (!empty($data_post['datetime']))
			$data["UF_DATETIME"] = $data_post['datetime'];

		$result = $entity_data_class::add($data);

		if ($result) {
			$_SESSION['messages']['success'][] = array(
				'text' => 'Задача успешно добавлена.',
			);
		}
		else{
			$_SESSION['messages']['error'][] = array(
				'text' => 'Что-то пошло не так',
			);
		}
		LocalRedirect("/");
	}

	public function executeComponent()
	{
		try
		{
			parent::checkModules();
			parent::GetEntityDataClass();

			$context = Context::getCurrent();
			$request = $context->getRequest();

			if ($request->getPost("submit") == 1) {

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