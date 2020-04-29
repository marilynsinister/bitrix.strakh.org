<?

function dz($var, $die = false)
{
	global $USER;

	if($USER instanceof CUser AND $USER->IsAdmin())
	{
		$trace = debug_backtrace();
		echo '<div style="display: block; position: relative; background-color: #ffffff; border: 1px solid #000000; padding: 5px; margin: 0;">';
		echo '<div style="display: block; position: relative; color: #808080; font-size: 12px; margin: 0; padding: 0;">from (<b>'.$trace[0]['file'].'</b>) on line <b>'.$trace[0]['line'].'</b></div><pre>';
		if(is_array($var)) print_r($var); else var_dump($var);
		echo '</pre></div>';

		if($die)
		{
			die();
		}
	}
}

/** z_add_url_get
 *
 * @param $a_data - массив с данными которые должны быть добавлены к строке
 * @param $url - адрес страницы, если false то берется текущтй url
 *
 *
 **/
function z_add_url_get($a_data, $url = false)
{
	//$http = $_SERVER['HTTPS'] ? 'https' : 'http';

	if ($url === false) {
		$url = $_SERVER['REQUEST_URI'];
	}

	$query_str = parse_url($url);
	$path = !empty($query_str['path']) ? $query_str['path'] : '';
	//$return_url = $query_str['scheme'] . '://' . $query_str['host'] . $path;
	$return_url = $path;
	$query_str = !empty($query_str['query']) ? $query_str['query'] : false;
	$a_query = array();

	if ($query_str) {
		parse_str($query_str, $a_query);
	}

	$a_query = array_merge($a_query, $a_data);
	$s_query = http_build_query($a_query);

	if ($s_query) {
		$s_query = '?' . $s_query;
	}

	return $return_url . $s_query;
}