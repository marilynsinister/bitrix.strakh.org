<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<? global $APPLICATION; ?>

<div class="row">
	<div class="col-10">
		<div class="h1"><h1>Список задач</h1></div>
	</div>
	<div class="col-2 my-auto">
		<a href="/new.php" class="btn btn-primary">Добавить новую</a>
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
		"SEF_MODE" => "N",
	),
	false
);
?>
		</div>

	</div>

<div class="row">
	<div class="col-12">
		<? if (isset($_GET['success_at']) && $_GET['success_at'] == 1): ?>
			<div class="alert alert-success" role="alert">
				Задача успешно добавлена.
			</div>
		<? elseif(isset($_GET['success_at']) && $_GET['success_at'] == 0): ?>
			<div class="alert alert-danger" role="alert">
				Что-то пошло не так
			</div>
		<? endif; ?>

		<? if (isset($_GET['success_et']) && $_GET['success_et'] == 1): ?>
			<div class="alert alert-success" role="alert">
				Задача успешно отредактирована.
			</div>
		<? elseif(isset($_GET['success_et']) && $_GET['success_et'] == 0): ?>
			<div class="alert alert-danger" role="alert">
				Что-то пошло не так
			</div>
		<? endif; ?>

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

			</tr>
			</thead>
			<tbody>
			<? foreach ($arResult['ITEMS'] as $item): ?>
				<tr>
					<th scope="row"><?=$item['ID']?></th>
					<td><?=$item['UF_NAME']?></td>
					<td><?=$item['UF_DATETIME']?></td>
					<td>
						<?=$item['UF_STATUS']?>

					</td>
					<td>
						<?=($item['UF_COMMENT'])?>
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
