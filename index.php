
	<?php
		session_start();//session_start phai dat truoc cac the html
		// Đường dẫn tới hệ  thống
		define('PATH_SYSTEM', __DIR__ .'/system');
		define('PATH_APPLICATION', __DIR__ . '/site');
		define('PATH_TEMPLATE',__DIR__ . '/public/templates/site');
		// Lấy thông số cấu hình
		require PATH_SYSTEM . '/config/config.php';

		//mở file Common.php, file này chứa hàm Load() chạy hệ thống
		include_once PATH_SYSTEM . '/core/Common.php';
		if($_GET['c']!='ajax'&&!($_GET['c']=='cart'&&$_GET['a']=='checkout'))
		include PATH_TEMPLATE.'/header.php';
		// Chương trình chính
		load();
		if($_GET['c']!='ajax'&&!($_GET['c']=='cart'&&$_GET['a']=='checkout'))
		include PATH_TEMPLATE.'/footer.php';
	?>
	
	
	