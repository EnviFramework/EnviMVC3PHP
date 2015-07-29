<%include file="_header.tpl"%>
<%include file="_error.tpl"%>

/*%%show_text%%*/

<ul class="list-group">
  <li class="list-group-item"><a href="./edit.php?id=<%$_____module_name_____.id%>">編集する</a></li>
  <li class="list-group-item"><a href="./destroy.php?id=<%$_____module_name_____.id%>">削除する</a></li>
  <li class="list-group-item"><a href="./index.php">一覧へ</a></li>
</ul>

<%include file="_footer.tpl"%>

