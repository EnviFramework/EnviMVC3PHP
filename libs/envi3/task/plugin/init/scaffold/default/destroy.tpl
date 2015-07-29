<%include file="_header.tpl"%>
<%include file="_error.tpl"%>
<form action="./destroy.php" method="post">
<input type="hidden" name="id" value="<%$smarty.get.id|default:$smarty.post.id%>">

ID:
<%$smarty.get.id|default:$smarty.post.id%>を削除します。


<button type="submit" name="commit" value="削除" class="btn btn-danger">削除</button>
</form>
<%include file="_footer.tpl"%>