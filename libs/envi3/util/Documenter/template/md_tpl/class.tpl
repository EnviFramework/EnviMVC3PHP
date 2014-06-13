<?=$class_name?> クラス
================================================================

導入
--------------------------------------------------------------
<?=$token->getDocBlockToken()->getDocBlockDetail()?>



クラス概要
--------------------------------------------------------------
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<?php foreach ($methods as $method_name => $method) { ?>
<?php
$doc_array = $method['token']->getDocBlockToken()->getDocBlockArray();
$return_text = '';
if (isset($doc_array['return'][0][0])) {
    $return_text = $doc_array['return'][0][0];
}

$keywords = $method['token']->getKeywords();
if (is_array($keywords)) {
    $keywords = join(' ', $keywords);
}


$arguments = $method['token']->getArguments();

$i = 0;
foreach ($arguments as $k => $v) {
    $arguments[$k] = '';
    if ($v['optional'] !== NULL) {
        $arguments[$k] .= '[ ';
    }
    if ($v['type_hint'] !== NULL) {
        $arguments[$k] .= $v['type_hint'].' '.$k;
    } elseif (isset($doc_array['param'][$i][0], $doc_array['param'][$i][1]) &&
        $doc_array['param'][$i][1] === $k
    ) {
        $arguments[$k] .= $doc_array['param'][$i][0].' '.$k;
    } else {
        echo $method['token']->getMethodName().' error';
        var_dump($doc_array['param'][$i]);
        var_dump($k);
        die();
    }
    if ($v['optional'] !== NULL) {
        $arguments[$k] .= ' = '.$v['optional'].']';
    }
    ++$i;
}
$argument = ' ';
if (is_array($arguments)) {
    $argument = join(', ', $arguments);
}
?>
<?=$keywords?> <?=$return_text?> <?=$method['token']->getName()?> (<?=$argument?>)
<?php } ?>

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

目次
---------------------------------------------------------------
<?php foreach ($methods as $method_name => $method) { ?>
  * [<?=$method['token']->getMethodName()?>](<?=$driver->writePathToManPath($method['man_path'])?>) — <?=$method['token']->getDocBlockToken()->getDocBlockSubject()?>

<?php } ?>
