クラスリファレンス
================================================================
<?php foreach ($category as $category_name => $package) { ?>

<?=$category_name?>

---------------------------------------------------------

<?php foreach ($package as $package_name => $package) { ?>
* <?=$package_name?>

<?php foreach ($package as $sub_package_name => $sub_package) { ?>
  * [<?=$sub_package_name?>](<?=$driver->writePathToManPath($sub_package['sub_package_man_path'])?>) 

<?php } ?>
<?php } ?>
<?php } ?>
