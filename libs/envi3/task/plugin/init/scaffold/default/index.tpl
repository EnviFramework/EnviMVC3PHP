<ul>
  <%foreach from=$lists item=item key=key%>
    <li><a href="./show.php?id=<%$item.id%>"><%$item.id%></a></li>
  <%/foreach%>
</ul>

