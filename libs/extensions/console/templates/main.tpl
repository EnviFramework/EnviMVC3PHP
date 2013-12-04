<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title>


</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/redmond/jquery-ui.css">
<link rel="stylesheet" href="<?php echo $_SERVER['PHP_SELF'];?>?f=jquery.treeview.css&<?php echo $_SERVER['QUERY_STRING'];?>">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script src="<?php echo $_SERVER['PHP_SELF'];?>?f=jquery.treeview.js&<?php echo $_SERVER['QUERY_STRING'];?>"></script>
<script src="<?php echo $_SERVER['PHP_SELF'];?>?f=console.log&<?php echo $_SERVER['QUERY_STRING'];?>"></script>


<script type="text/javascript">


		$(function() {

			$(".tree").treeview({
				collapsed: true,
				animated: "medium",
				persist: "location"
			});



		})

	</script>

  </head>
 <body>




  </body>
</html>