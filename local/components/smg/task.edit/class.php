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

class CTaskManagerEdit extends CTaskManager
{


	public function onPrepareComponentParams($params)
	{

		$params = parent::onPrepareComponentParams($params);

		$params['ELEMENT_ID'] = (int)$params['ELEMENT_ID'];

		return $params;

	}

	protected function getItem($id)
	{
		$entity_data_class = $this->entityClass;

		$arItem = array();

		$rsData = $entity_data_class::getList(array(
			"select" => array("*"),
			"filter" => array("ID" => $id, "UF_ACTIVE"=>1),  // Задаем параметры фильтра выборки

		));

		while($arData = $rsData->Fetch()){

			parent::prepareDate($arData);
			$arItem = $arData;
		}
		$UserField = CUserFieldEnum::GetList(array(), array("USER_FIELD_ID" => 4));

		while($UserFieldAr = $UserField->GetNext())
		{
			$this->arResult['STATUSES'][] = $UserFieldAr;
		}

		$this->arResult['ITEM'] = $arItem;
		//dz($this->arResult);
	}

	protected function update($id, &$data_post)
	{
		$entity_data_class = $this->entityClass;

		// Массив полей для добавления
		$data = array(
			"UF_NAME"		 	=> $data_post['name'],
			"UF_DATETIME" 		=> $data_post['datetime'],
			"UF_STATUS"			=> $data_post['status'],
			"UF_COMMENT" 		=> $data_post['comment'],
		);

		$result = $entity_data_class::update($id, $data);

		if ($result) {
			$_SESSION['messages']['success'][] = array(
				'text' => 'Задача успешно изменена.',
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

			$this->getItem($this->arParams["ELEMENT_ID"]);

			if ($request->getPost("submit") == 1) {

				$this->update($request->getQuery("id"), $request->getPostList($request->getPost("id")));
			}
			$this->includeComponentTemplate();
		}
		catch (SystemException $e)
		{
			ShowError($e->getMessage());
		}
	}
}?>