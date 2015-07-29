<%include file="_header.tpl"%>
<%include file="_error.tpl"%>
<ul class="list-group">
  <%foreach from=$lists item=item key=key%>
    <li class="list-group-item"><a href="./show.php?id=<%$item.id%>"><%$item.id%></a></li>
  <%/foreach%>
</ul>

<ul class="list-group">
  <li class="list-group-item"><a href="./new.php">登録する</a></li>
</ul>

<%include file="_footer.tpl"%>