<%if $smarty.server.PHP_SELF === '/c/man/v3/reference'%>
<li class="active"><a href="/c/man/v3/reference"><strong>クラスリファレンス</strong></a>
<ul class="nav">
<?php foreach ($category as $category_name => $package) { ?>
<?php foreach ($package as $package_name => $package) { ?>
<li><a href="/c/man/v3/reference/<?=urlencode($package_name)?>"><strong><?=$package_name?></strong></a></li>
<?php } ?>
<?php } ?>
</ul>
</li>


<?php foreach ($category as $category_name => $package) { ?>
<?php foreach ($package as $package_name => $package) { ?>
<?php foreach ($package as $sub_package_name => $sub_package) { ?>
<%elseif strpos($smarty.server.PHP_SELF, '/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>') === 0 %>
<li><a href="/c/man/v3/reference"><strong>クラスリファレンス</strong></a></li>
<li><a href="/c/man/v3/reference/<?=urlencode($package_name)?>"><strong><?=($package_name)?></strong></a></li>
  <%if $smarty.server.PHP_SELF == "/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>"%><li class="active"><%else%><li><%/if%>
      <a href="/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>"><strong><?=($sub_package_name)?></strong></a>
  </li>
  <%if $smarty.server.PHP_SELF == "/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/intro"%><li class="active"><%else%><li><%/if%>
  <a href="/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/intro">導入</a></li>
  <%if $smarty.server.PHP_SELF == "/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/setup"%><li class="active"><%else%><li><%/if%>
  <a href="/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/setup">インストール/設定</a></li>
  <%if $smarty.server.PHP_SELF == "/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/constants"%><li class="active"><%else%><li><%/if%>
  <a href="/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/constants">定義済み定数</a></li>
  <?php foreach ($sub_package['class_list'] as $class_name => $class_item) { ?>
  <%if strpos($smarty.server.PHP_SELF, '/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/<?=$class_name?>') === 0 %><li class="active"><%else%><li><%/if%>
	<a href="/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/<?=$class_name?>"><?=$class_name?></a>
	<ul class="nav">
      <?php foreach ($class_item['methods'] as $method_name => $methods) { ?>
		<%if strpos($smarty.server.PHP_SELF, '/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/<?=$class_name?>/<?=$methods['method_name']?>') === 0 %><li class="active"><%else%><li><%/if%><a href="/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>/<?=$class_name?>/<?=$methods['method_name']?>"><?=$methods['method_name']?></a>
      <?php } ?>
    	</ul>
</li>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>

<%elseif strpos($smarty.server.PHP_SELF, '/c/man/v3/reference/') === 0 %>
<li><a href="/c/man/v3/reference"><strong>クラスリファレンス</strong></a></li>
<?php foreach ($category as $category_name => $package) { ?>
<?php foreach ($package as $package_name => $package) { ?>
<li <%if $smarty.server.PHP_SELF === '/c/man/v3/reference/<?=urlencode($package_name)?>'%>class="active"<%/if%>><a href="/c/man/v3/reference/<?=urlencode($package_name)?>"><strong><?=$package_name?></strong></a>
<ul class="nav">
<?php foreach ($package as $sub_package_name => $sub_package) { ?>
<li><a href="/c/man/v3/reference/<?=urlencode($package_name)?>/<?=urlencode($sub_package_name)?>"><strong><?=$sub_package_name?></strong></a></li>
<?php } ?>
</ul>
</li>
<?php } ?>
<?php } ?>
<%else%>
<li><a href="/c/man/v3/reference"><strong>クラスリファレンス</strong></a></li>
<%/if%>
