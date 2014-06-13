<?=$sub_package_name?>

================================================================
* [導入](<?=$driver->writePathToManPath($sub_package['intro_man_path'])?>)
* [インストール/設定](<?=$driver->writePathToManPath($sub_package['setup_man_path'])?>)
* [定義済み定数](<?=$driver->writePathToManPath($sub_package['constant_man_path'])?>)
<?php foreach ($class_list as $class_name => $class_item) { ?>
* [<?=$class_name?>](<?=$driver->writePathToManPath($class_item['class_item']['man_path'])?>) — <?=$class_item['class_item']['token']->getDocBlockToken()->getDocBlockSubject()?>

<?php foreach ($class_item['methods'] as $method_name => $method) { ?>
  * [<?=$method['token']->getMethodName()?>](<?=$driver->writePathToManPath($method['man_path'])?>) — <?=$method['token']->getDocBlockToken()->getDocBlockSubject()?>

<?php } ?>
<?php } ?>
