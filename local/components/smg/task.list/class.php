<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\Date;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;


class CTaskManager extends CBitrixComponent
{
	//Родительский метод проходит по всем параметрам переданным в $APPLICATION->IncludeComponent
	//и применяет к ним функцию htmlspecialcharsex. В данном случае такая обработка избыточна.
	//Переопределяем.
	/*public function onPrepareComponentParams($arParams)
	{
		$result = array(
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => isset($arParams["CACHE_TIME"]) ?$arParams["CACHE_TIME"]: 36000000,
		);
		return $result;
	}*/

	/*protected function getCacheKeys()
	{
		return array(

		);
	}*/

	/*protected function getFilter()
	{
		$filterFields = parent::getFilter();

		return $filterFields;
	}*/
	protected function prepareDate(&$arItem)
	{
		$DateFormat = $this->arParams["DATE_FORMAT"];


		if (strlen($arItem["UF_DATETIME"]) > 0) {

			$arItem["UF_DATETIME"] = $arItem["UF_DATETIME"]->format($DateFormat);
		}
	}

	protected function getSortParam(){

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
		if ($this->errors)
			throw new SystemException(current($this->errors));

		$additionalCacheID = false;
		//if ($this->startResultCache($this->arParams['CACHE_TIME'], $additionalCacheID)) {

			//SELECT
			/*$arSelect = array_merge($this->arParams["FIELD_CODE"], array(
				"IBLOCK_ID",
				"ID",
			));

			foreach ($this->arParams["PROPERTY_CODE"] as $prop_name) {
				$arSelect[] = "PROPERTY_" . $prop_name;
			}

			//WHERE
			$arFilter = array(
				"IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
				"IBLOCK_LID" => SITE_ID,
				"ACTIVE" => "Y",
			);

			//ORDER BY
			$arSort = array(
				$this->arParams["SORT_BY1"] => $this->arParams["SORT_ORDER1"]
			);

			if (!array_key_exists("ID", $arSort))
				$arSort["ID"] = "DESC";

			$arNavParams["nTopCount"] = $this->arParams['TOP_COUNT'];

			//GETLIST
			$rsElement = CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams, $arSelect);

			dz($arFilter);
			if (!$rsElement) {
				$this->abortResultCache();
			}

			$rsElement->SetUrlTemplates($this->arParams["DETAIL_URL"], "", $this->arParams["IBLOCK_URL"]);

			while ($obElement = $rsElement->GetNextElement()) {
				$arItem = $obElement->GetFields();

				//$this->prepareDate($arItem);

				$arResult["ITEMS"][] = $arItem;
			}*/
		//if ($this->startResultCache($this->arParams['CACHE_TIME'], $additionalCacheID)) {
			$hlbl = 1; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
			$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

			$entity = HL\HighloadBlockTable::compileEntity($hlblock);

			$entity_data_class = $entity->getDataClass();

			$arItems = array();

			$nav = new \Bitrix\Main\UI\PageNavigation("nav-more-news");
			$nav->allowAllRecords($this->arParams["PAGE_SHOW_ALL"])
				->setPageSize($this->arParams["PAGE_COUNT"])
				->initFromUri();

			$sort = $this->getSortParam();

			$rsData = $entity_data_class::getList(array(
				"select" => array("*"),
				"order" => array($sort['field'] => $sort['order']),
				"filter" => array("UF_ACTIVE"=>1),  // Задаем параметры фильтра выборки
				"count_total" => true,
				"offset" => $nav->getOffset(),
				"limit" => $nav->getLimit(),
			));

			if (!$rsData) {
				$this->abortResultCache();
			}

			$nav->setRecordCount($rsData->getCount());

			while($arData = $rsData->Fetch()){

				$this->prepareDate($arData);
				$arItems[] = $arData;
			}

			$this->arResult['NAV'] = $nav;
			$this->arResult['ITEMS'] = $arItems;

		//}
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
			$this->getResult();
			$this->includeComponentTemplate();
		}
		catch (SystemException $e)
		{
			ShowError($e->getMessage());
		}
	}
}?>