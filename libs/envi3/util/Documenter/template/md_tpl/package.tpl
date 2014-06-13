<?=$package_name?>

================================================================
<?php foreach ($package as $sub_package_name => $sub_package) { ?>
  * [<?=$sub_package_name?>](<?=$driver->writePathToManPath($sub_package['sub_package_man_path'])?>) 

<?php } ?>
