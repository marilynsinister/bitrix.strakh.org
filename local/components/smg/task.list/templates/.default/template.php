<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<? global $APPLICATION;?>

<div class="row">
	<div class="col-10">
		<div class="h1"><h1>Список задач</h1></div>
	</div>
	<div class="col-2 my-auto">
		<a href="<?=$arParams['NEW_URL']?>" class="btn btn-primary">Добавить новую</a>
	</div>
</div>

	<div class="row">
	<div class="col-12">
<?
$APPLICATION->IncludeComponent(
	"bitrix:main.pagenavigation",
	"",
	array(
		"NAV_OBJECT" => $arResult['NAV'],
		"SEF_MODE" => "Y",
	),
	false
);
?>
		</div>

	</div>

<div class="row">
	<div class="col-12">
		<? foreach ($_SESSION['messages']['error'] as $k => $error): ?>
			<div class="alert alert-danger" role="alert">
				<?=$error['text']?>
			</div>
		<? unset($_SESSION['messages']['error'][$k]);
		endforeach; ?>
		<? foreach ($_SESSION['messages']['success'] as $k => $success): ?>
			<div class="alert alert-success" role="alert">
				<?=$success['text']?>
			</div>
			<? unset($_SESSION['messages']['success'][$k]);
		endforeach; ?>


	</div>
</div>
<div class="row">
	<div class="col-12">

		<table class="table table-hover c-table">
			<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">
					<a href="<?=((isset($_GET['order']) && $_GET['order']=='asc')?z_add_url_get(array('sort' => 'name', 'order' => 'desc')):z_add_url_get(array('sort' => 'name', 'order' => 'asc')))?>">
						Название
						<?if (isset($_GET['sort']) && $_GET['sort'] == 'name'){
							if ($_GET['order']=='asc') echo '&#9650;';
							else echo '&#9660;';
						}?>
					</a>
				</th>
				<th scope="col">
					<a href="<?=((isset($_GET['order']) && $_GET['order']=='asc')?z_add_url_get(array('sort' => 'date', 'order' => 'desc')):z_add_url_get(array('sort' => 'date', 'order' => 'asc')))?>">
						Дата и время
						<?if (isset($_GET['sort']) && $_GET['sort'] == 'date'){
							if ($_GET['order']=='asc') echo '&#9650;';
							else echo '&#9660;';
						}?>
					</a>
				</th>
				<th scope="col">
					<a href="<?=((isset($_GET['order']) && $_GET['order']=='asc')?z_add_url_get(array('sort' => 'status', 'order' => 'desc')):z_add_url_get(array('sort' => 'status', 'order' => 'asc')))?>">
						Статус
						<?if (isset($_GET['sort']) && $_GET['sort'] == 'status'){
							if ($_GET['order']=='asc') echo '&#9650;';
							else echo '&#9660;';
						}?>
					</a>
				</th>
				<th scope="col">
					Комментарий
				</th>
				<th scope="col">

				</th>

			</tr>
			</thead>
			<tbody>
			<? foreach ($arResult['ITEMS'] as $item): ?>
				<tr>
					<th scope="row"><?=$item['ID']?></th>
					<td><?=$item['UF_NAME']?></td>
					<td><?=$item['UF_DATETIME']?></td>
					<td class="status">
						<?=$item['STATUS']?>

					</td>
					<td>
						<?=($item['UF_COMMENT'])?>
					</td>
					<td>
						<? if ($item['UF_STATUS'] != 3): ?>
							<a href="#"><i class="fas fa-check" data-id="<?=$item['ID']?>"></i></a>
						<? endif; ?>
						<a href="<?=$item['EDIT_URL']?>"><i class="fas fa-edit"></i></a>
						<a href="#"><i class="fas fa-times" data-id="<?=$item['ID']?>"></i></i></a>
					</td>
				</tr>
			<? endforeach;?>

			</tbody>
		</table>
	</div>
</div>
<?
$APPLICATION->IncludeComponent(
	"bitrix:main.pagenavigation",
	"",
	array(
		"NAV_OBJECT" => $arResult['NAV'],
		"SEF_MODE" => "Y",
	),
	false
);
?>
