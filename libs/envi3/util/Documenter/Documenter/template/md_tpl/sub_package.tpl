<?=$sub_package_name?>

================================================================
* [導入](./<?=$sub_package_name?>/intro)
* [インストール/設定](./<?=$sub_package_name?>/intro#install)
* [定義済み定数](./<?=$sub_package_name?>/constant)
<?php foreach ($class_list as $class_name => $class_item) { ?>
* [<?=$class_name?>](<?=$driver->writePathToManPath($class_item['class_item']['man_path'])?>) — <?=$class_item['class_item']['token']->getDocBlockToken()->getDocBlockSubject()?>

<?php foreach ($class_item['methods'] as $method_name => $method) { ?>
  * [<?=$method['token']->getMethodName()?>](<?=$driver->writePathToManPath($method['man_path'])?>) — <?=$method['token']->getDocBlockToken()->getDocBlockSubject()?>

<?php } ?>
<?php } ?>
