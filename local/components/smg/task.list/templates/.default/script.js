$(document).ready(function () {

	$('.c-table .fa-check').on('click', function (e) {
		e.preventDefault();
		var row = $(this);

		if($(this).data('id') > 0) {

			$.ajax({
				type: 'POST',
				url: '/local/components/smg/task.list/ajax.php',
				data: {
					action: 'setComplete',
					item: $(this).data('id'),
					crc: MD5($(this).data('id') + 'bitrix')
				},
				success: function (data) {
					if (data == '1'){
						$(row.parents('tr').find('.status').html('Выполнена'));
					}

				},
			});
		}
	});

	$('.c-table .fa-times').on('click', function (e) {
		e.preventDefault();
		var row = $(this);

		if($(this).data('id') > 0) {

			$.ajax({
				type: 'POST',
				url: '/local/components/smg/task.list/ajax.php',
				data: {
					action: 'setInactive',
					item: $(this).data('id'),
					crc: MD5($(this).data('id') + 'bitrix')
				},
				success: function (data) {
					if (data == '1'){
						$(row.parents('tr').remove());
					}

				},
			});
		}
	});

});