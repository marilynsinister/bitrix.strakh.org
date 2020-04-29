<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */


$arDefaultUrlTemplates404 = array(
	"tasks"  => "",
	"new"	 => "new/",
	"edit"   => "edit/#id#/",
);

$arDefaultVariableAliases404 = array();

$arDefaultVariableAliases = array();

$arComponentVariables = array(
	"id",
);


if($arParams["SEF_MODE"] == "Y")
{
	$arVariables = array();

	$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
		$arDefaultUrlTemplates404,
		$arParams['SEF_URL_TEMPLATES']
	);

	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases(
		$arDefaultVariableAliases404,
		$arParams['VARIABLE_ALIASES']
	);

	$componentPage = CComponentEngine::ParseComponentPath(
		$arParams['SEF_FOLDER'],
		$arUrlTemplates,
		$arVariables
	);

	if (strlen($componentPage) <= 0) {
		$componentPage = 'tasks';
	}

	CComponentEngine::InitComponentVariables(
		$componentPage,
		$arComponentVariables,
		$arVariableAliases,
		$arVariables);

	$SEF_FOLDER = $arParams['SEF_FOLDER'];

	$arResult = array(
		"FOLDER" => $arParams["SEF_FOLDER"],
		"URL_TEMPLATES" => $arUrlTemplates,
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases,
	);
}
else
{
	// todo
}


$this->includeComponentTemplate($componentPage);