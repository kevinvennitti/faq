<?php
	if ($_GET['type'] == 'get') {
		if ($_GET['data'] == 'data') {
			echo file_get_contents('./data/data.json');
		}
	}

	if ($_GET['type'] == 'post') {
		if ($_GET['data'] == 'data') {
			$data = $_GET['fields']['data'];

			

			file_put_contents('./data/data.json', $data);

		}
	}
