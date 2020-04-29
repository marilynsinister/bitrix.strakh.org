<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Data\cache;


use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;


class CTaskManager extends CBitrixComponent
{

	protected $entityClass;

	public function __construct($component, $hlbl = null)
	{
		parent::__construct($component);
		if (!is_null($hlbl)){
			$this->arParams['HIBLOCK_ID'] = intval($hlbl);
		}
	}

	protected function GetEntityDataClass()
	{
		$hlbl = $this->arParams['HIBLOCK_ID'];

		$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

		$entity = HL\HighloadBlockTable::compileEntity($hlblock);

		$entity_data_class = $entity->getDataClass();

		$this->entityClass = $entity_data_class;

		return $this->entityClass;
	}
	protected function prepareDate(&$arItem)
	{
		$DateFormat = $this->arParams["DATE_FORMAT"];

		if (!empty($arItem["UF_STATUS"])){
			$UserField = CUserFieldEnum::GetList(array(), array("USER_FIELD_ID" => 4));

			while($UserFieldAr = $UserField->GetNext())
			{
				if ($UserFieldAr['ID'] == $arItem["UF_STATUS"]){
					$arItem["STATUS"] = $UserFieldAr['VALUE'];
				}
			}
		}
		$arItem["EDIT_URL"] = str_replace('#id#', $arItem["ID"], $this->arParams['EDIT_URL']);
		if (strlen($arItem["UF_DATETIME"]) > 0) {

			$arItem["UF_DATETIME"] = $arItem["UF_DATETIME"]->format($DateFormat);
		}
	}

	protected function getSortParam()
	{

		$sort = array(
			'field' => 'UF_DATETIME',
			'order' => 'DESC',
		);

		if (!empty($this->arParams['SORT_BY1'])) {

			switch ($this->arParams['SORT_BY1']) {
				case "name":
					$field = "UF_NAME";
					break;
				case "date":
					$field = "UF_DATETIME";
					break;
				case "status":
					$field = "UF_STATUS";
					break;
				default:
					$field = "UF_DATETIME";
			}

			if (!empty($this->arParams['SORT_ORDER1']) && $this->arParams['SORT_ORDER1'] == 'asc'){
				$order = "ASC";
			}
			else{
				$order = "DESC";
			}

			$sort = array(
				'field' => $field,
				'order' => $order,
			);
		}

		return $sort;

	}
	protected function getResult()
	{

		$cache = cache::createInstance();
		$sort = $this->getSortParam();

		$nav = new \Bitrix\Main\UI\PageNavigation("nav-more-news");
		$nav->allowAllRecords($this->arParams["PAGE_SHOW_ALL"])->setPageSize($this->arParams["PAGE_COUNT"])->initFromUri();

		$cache_id = $sort['field'].$sort['order'].$nav->getOffset().$nav->getLimit();

		if ($cache->initCache($this->arParams['CACHE_TIME'], $cache_id,'/cache/tasks/'))
		{
			$this->arResult = $cache->getVars();

		}
		elseif ($cache->startDataCache()) {

			$entity_data_class = $this->entityClass;

			$arItems = array();

			$nav = new \Bitrix\Main\UI\PageNavigation("nav-more-news");
			$nav->allowAllRecords($this->arParams["PAGE_SHOW_ALL"])->setPageSize($this->arParams["PAGE_COUNT"])->initFromUri();



			$rsData = $entity_data_class::getList(array(
				"select" => array("*"),
				"order" => array($sort['field'] => $sort['order']),
				"filter" => array("UF_ACTIVE" => 1),  // Задаем параметры фильтра выборки
				"count_total" => true,
				"offset" => $nav->getOffset(),
				"limit" => $nav->getLimit(),
			));

			$nav->setRecordCount($rsData->getCount());

			while ($arData = $rsData->Fetch()) {

				$this->prepareDate($arData);
				$arItems[] = $arData;
			}

			$this->arResult['NAV'] = $nav;
			$this->arResult['ITEMS'] = $arItems;

			$cache->endDataCache($this->arResult);
		}


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

	public function setComplete($id)
	{
		$this->GetEntityDataClass();

		$entity_data_class = $this->entityClass;

		// Массив полей для добавления
		$data = array(
			"UF_STATUS"			=> 3,
		);

		$result = $entity_data_class::update($id, $data);

		if ($result->isSuccess()){
			$cache = \Bitrix\Main\Data\Cache::createInstance();
			$cache->cleanDir('/cache/tasks/');
		}
		return $result->isSuccess();

	}

	public function setInactive($id)
	{
		$this->GetEntityDataClass();

		$entity_data_class = $this->entityClass;

		// Массив полей для добавления
		$data = array(
			"UF_ACTIVE"			=> 0,
		);

		$result = $entity_data_class::update($id, $data);

		if ($result->isSuccess()){
			$cache = \Bitrix\Main\Data\Cache::createInstance();
			$cache->cleanDir('/cache/tasks/');
		}

		return $result->isSuccess();

	}

	public function executeComponent()
	{
		try
		{
			$this->checkModules();
			$this->GetEntityDataClass();
			$this->getResult();
			$this->includeComponentTemplate();
		}
		catch (SystemException $e)
		{
			ShowError($e->getMessage());
		}
	}
}?>