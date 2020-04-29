<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<? global $APPLICATION;?>

<div class="row">
	<div class="col-6">

		<h1>Задача #<?=$arResult['ITEM']['ID']?></h1>
		<form method="post">
			<div class="form-group">
				<label for="InputName">Название</label>
				<input type="text" name="name" value="<?=$arResult['ITEM']['UF_NAME']?>" class="form-control needs-validation" id="InputName"  placeholder="Введите имя" required>
			</div>
			<div class="form-group">
				<label for="datetimepicker1">Дата и время</label>
				<div  class="input-group date" data-target-input="nearest">
					<input id="datetimepicker1" value="<?=$arResult['ITEM']['UF_DATETIME']?>" data-format="dd.mm.yyyy hh:mm:ss" type="text" name="datetime" class="form-control needs-validation" placeholder="Введите дату" />
					<div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
						<div class="input-group-text"><i class="fa fa-calendar"></i></div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="status">Статус</label>
				<select class="form-control" id="status" name="status">
					<? foreach ($arResult['STATUSES'] as $status):?>
						<option value="<?=$status['ID']?>"<?=(($status['ID'] == $arResult['ITEM']['UF_STATUS'])?"selected":"")?>><?=$status['VALUE']?></option>
					<? endforeach;?>
				</select>
			</div>
			<div class="form-group">
				<label for="InputComment">Комментарий</label>
				<textarea  rows="5" name="comment" class="form-control needs-validation" id="InputComment" placeholder="Комментарий" required><?=$arResult['ITEM']['UF_COMMENT']?></textarea>
			</div>

			<button type="submit" name="submit" value="1" class="btn btn-primary">Изменить</button>
		</form>
	</div>
</div>

