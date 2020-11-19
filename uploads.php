<?php

$dir_categorys = 'img/superbox/';

function getCategorys($dir_categorys)
{
    $menu = [];
    $d = opendir($dir_categorys);
    while ($menuItem = readdir($d)) 
    {
        if ($menuItem == '.' || $menuItem == '..') 
        {
            if (is_file($menuItem)) 
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

$menuCategorys = getCategorys($dir_categorys);

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if($_FILES['file']['error'] == 0)
    {
        if(!empty($_POST['new_category']))
        {
            if(file_exists($dir_categorys . $_POST['new_category']))
            {
                $path = $dir_categorys . $_POST['new_category'] . '/' . time() . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['file']['tmp_name'], $path);
            }
            else
            {
                mkdir($dir_categorys . $_POST['new_category']);
                $path = $dir_categorys . $_POST['new_category'] . '/' . time() . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['file']['tmp_name'], $path);
            }
        }
        else
        {
            $path = $dir_categorys . $_POST['name_category'] . '/' . time() . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['file']['tmp_name'], $path);
        }
    }
}


echo '<pre>';
print_r($_FILES);
echo '</pre>';

echo '<pre>';
print_r($_POST);
echo '</pre>';

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма</title>
</head>

<body>
    <div class="form_action">
        <H1>Загрузите файл</H1>
        <form action="#" method="POST" enctype="multipart/form-data">
            <fieldset>
                <label for="name_category">Выберите категорию</label>
                <select name="name_category" id="name_category">
                    <?php if (!empty($menuCategorys)) : ?>
                        <?php foreach ($menuCategorys as $key => $value) : ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </fieldset>

            <fieldset>
                <label for="new_name_category">Название новой категории</label>
                <input type="text" name="new_category" id="new_name_category">
            </fieldset>

            <fieldset>
                <label for="select_file">Выберите файл</label>
                <input type="file" name="file" id="new_file">
            </fieldset>

            <button type="submit">Отправить</button>
        </form>
    </div>
</body>

</html>