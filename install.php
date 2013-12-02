<?php
$php_path = `which php`;
echo "#!".$php_path."\n";
echo '<'.'?'.'php'."\n";
echo '$envi_dir = \''.dirname(__FILE__).DIRECTORY_SEPARATOR.'libs/envi3/\';'."\n";
echo '$base_dir = \''.dirname(__FILE__).DIRECTORY_SEPARATOR.'\';'."\n";
echo '$current_work_dir = getcwd().DIRECTORY_SEPARATOR;'."\n";
echo 'require $envi_dir.\'task/envi.php\';'."\n";




