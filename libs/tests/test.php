#!/usr/bin/php
<?php
$cmds = array('cp -rf ../envi3/test/* ./unit/');


foreach ($cmds as $cmd) {
    echo `$cmd`;
}
