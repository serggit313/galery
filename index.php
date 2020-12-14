<?php
session_start();
if(!empty($_GET['category']))
{
	$HTTPR =  $_GET['category'];
}
else
{
	$HTTPR = 'category1';
}



$dir_path = 'img/superbox/' . $HTTPR;
$dir_menu = 'img/superbox/';
$is_error404 = false;




// Получаем картинки 
function getImg($dir_path)
{
	$pictures = [];
	$d = opendir($dir_path);
		while($file = readdir($d))
		{
			if($file == '.' || $file == '..')
			{
				continue;
			}
			elseif(pathinfo($file, PATHINFO_EXTENSION) == 'jpg' || pathinfo($file, PATHINFO_EXTENSION) == 'png')
			{
				$pictures[] = $dir_path . '/' . $file;
			}
		}
	closedir($d);
	return $pictures;
}



// Показываем картинки
function showImg($pictures)
{
	if(!empty($pictures))
	{
		foreach($pictures as $key=>$value)
		{?>
			<div class="superbox-list">
				<img src="<?=$value; ?>" data-img="<?=$value; ?>"" alt="" class="superbox-img">
			</div>
		<?php }
	}
}


// Функция вывода ошибок
function error404()
{
	header("HTTP/1.0 404 Not Found");
}

// Получаем элементы меню
function getMenu($dir_menu)
{
	$menu = [];
	$d = opendir($dir_menu);
		while($menuItem = readdir($d))
		{
			if($menuItem == '.' || $menuItem == '..') 
			{
				if(is_file($menuItem))
				{
					continue;
				}
			}
			else
			{
				$menu[] = $menuItem;
			}
		}
	closedir($d);
	return $menu;
}

$menu = getMenu($dir_menu);



if(file_exists($dir_path))
{
	$pictures = getImg($dir_path);
}
else
{
	error404();
	global $is_error404;
	$is_error404 = true;
}

function is_user()
{
	if(!empty($_SESSIION['user']) || !empty($_COOKIE['user']))
	{
		return true;
	}
	return false;
}

?>


<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Superbox, the lightbox, reimagined</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="css/style.css" rel="stylesheet">
	</head>
	<body>
		<div class="wrapper">
			<div class="logo">
				<img src="img/logo.png" class="logo-img" alt="Logo">
			</div>
		<?php if(!is_user()):?>	
			<div>
				<p>
					<a href="reg.php">Регистрация</a>
				</p>
				<p>
					<a href="auth.php">Авторизация</a>
				</p>
			</div>
		<?php else:?>
			<?php if($is_error404) :?>
				<h1>Ошибка 404!</h1>
			<?php else: ?>
				<div class="menu">
					<?php if(!empty($menu)):?>
						<?php foreach($menu as $key=>$value):?>
						<ul>
							<li>
								<a class="<?php if($value == $HTTPR) echo 'active_link'?>" href="index.php?category=<?php echo $value;?>">
									<?php echo $value;?>
								</a>
							</li>
						</ul>
						<?php endforeach;?>
					<?php endif;?>
					<a href="uploads.php">Загрузить картинки</a>
					<a href="exit.php">Выйти</a>
				</div>

			<!-- SuperBox -->
			<div class="superbox">
				<?php
					showImg($pictures);
				?>
				<div class="superbox-float"></div>
			</div>
			<!-- /SuperBox -->
		
			<div style="height:300px;"></div>
			<?php endif;?>
		<?php endif;?>
		</div>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="js/superbox.js"></script>
		<script>
		$(function() {
		
			// Call SuperBox
			$('.superbox').SuperBox();
		
		});
		</script>
	</body>
</html>