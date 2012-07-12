<%* vim: set expandtab tabstop=4 shiftwidth=4: *%>
<%*
// +----------------------------------------------------------------------+
// |                            ARTISAN Smarty                            |
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright 2004-2005 ARTISAN PROJECT All rights reserved.             |
// +----------------------------------------------------------------------+
// | Authors: Akito<akito-artisan@five-foxes.com>                         |
// +----------------------------------------------------------------------+
//
 *
 * ARTISAN PROJECT
 * 
 * マルチバイト対応Smarty
 * + 付加システム
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @link http://smarty.php.net/
 * @link http://php.five-foxes.com/
 * @copyright 2001-2005 New Digital Group, Inc.
 * @copyright 2004-2005 Artisan Project
 * @author Monte Ohrt <monte at ohrt dot com>
 * @author Andrei Zmievski <andrei@php.net>
 * @author Akito <akito-artisan@five-foxes.com>
 * @package ArtisanSmarty
 * @version 1.0.9
 *%>
 
<%assign_debug_info%>
<%if isset($_smarty_debug_output) and $_smarty_debug_output == "html"%>
	<table border=0 width=100%>
	<tr bgcolor=#cccccc><th colspan=2>ArtisanSmarty デバッグコンソール</th></tr>
	<tr bgcolor=#cccccc><td colspan=2><b>include されているテンプレートファイル と configファイル (load time in seconds):</b></td></tr>
	<%section name=templates loop=$_debug_tpls%>
		<tr bgcolor=<%if %templates.index% is even%>#eeeeee<%else%>#fafafa<%/if%>>
			<td colspan=2><tt><%section name=indent loop=$_debug_tpls[templates].depth%>&nbsp;&nbsp;&nbsp;<%/section%><font color=<%if $_debug_tpls[templates].type eq "template"%>brown<%elseif $_debug_tpls[templates].type eq "insert"%>black<%else%>green<%/if%>><%$_debug_tpls[templates].filename|escape:html%></font><%if isset($_debug_tpls[templates].exec_time)%> <font size=-1><i>(<%$_debug_tpls[templates].exec_time|string_format:"%.5f"%>)<%if %templates.index% eq 0%> (total)<%/if%></i></font><%/if%></tt></td></tr>
	<%sectionelse%>
		<tr bgcolor=#eeeeee><td colspan=2><tt><i>テンプレートファイルは読み込まれていません。</i></tt></td></tr>	
	<%/section%>
	<tr bgcolor=#cccccc><td colspan=2><b>プログラムからassignされているテンプレート変数:</b></td></tr>
	<%section name=vars loop=$_debug_keys%>
		<tr bgcolor=<%if %vars.index% is even%>#eeeeee<%else%>#fafafa<%/if%>><td valign=top><tt><font color=blue>{$<%$_debug_keys[vars]%>}</font></tt></td><td nowrap><tt><font color=green><%$_debug_vals[vars]|@debug_print_var%></font></tt></td></tr>
	<%sectionelse%>
		<tr bgcolor=#eeeeee><td colspan=2><tt><i>何もassignされていません。</i></tt></td></tr>	
	<%/section%>
	<tr bgcolor=#cccccc><td colspan=2><b>コンフィグファイルからのテンプレート変数:</b></td></tr>
	<%section name=config_vars loop=$_debug_config_keys%>
		<tr bgcolor=<%if %config_vars.index% is even%>#eeeeee<%else%>#fafafa<%/if%>><td valign=top><tt><font color=maroon>{#<%$_debug_config_keys[config_vars]%>#}</font></tt></td><td><tt><font color=green><%$_debug_config_vals[config_vars]|@debug_print_var%></font></tt></td></tr>
	<%sectionelse%>
		<tr bgcolor=#eeeeee><td colspan=2><tt><i>コンフィグファイルからのテンプレート変数はありません。</i></tt></td></tr>	
	<%/section%>
	</table>
</BODY></HTML>
<%else%>
<SCRIPT language=javascript>
	if( self.name == '' ) {
	   var title = 'Console';
	}
	else {
	   var title = 'Console_' + self.name;
	}
	_smarty_console = window.open("",title.value,"width=680,height=600,resizable,scrollbars=yes");
	_smarty_console.document.write("<HTML><HEAD><TITLE>ArtisanSmarty デバッグコンソール&nbsp;&nbsp;["+self.name+"]&nbsp;&nbsp;</TITLE></HEAD><BODY bgcolor=#ffffff>");
	_smarty_console.document.write("<table border=0 width=100%>");
	_smarty_console.document.write("<tr bgcolor=#cccccc><th colspan=2>ArtisanSmarty デバッグコンソール</th></tr>");
	_smarty_console.document.write("<tr bgcolor=#cccccc><td colspan=2><b>include されているテンプレートファイル と config ファイル (load time in seconds):</b></td></tr>");
	<%section name=templates loop=$_debug_tpls%>
		_smarty_console.document.write("<tr bgcolor=<%if %templates.index% is even%>#eeeeee<%else%>#fafafa<%/if%>><td colspan=2><tt><%section name=indent loop=$_debug_tpls[templates].depth%>&nbsp;&nbsp;&nbsp;<%/section%><font color=<%if $_debug_tpls[templates].type eq "template"%>brown<%elseif $_debug_tpls[templates].type eq "insert"%>black<%else%>green<%/if%>><%$_debug_tpls[templates].filename|escape:html|escape:javascript%></font><%if isset($_debug_tpls[templates].exec_time)%> <font size=-1><i>(<%$_debug_tpls[templates].exec_time|string_format:"%.5f"%>)<%if %templates.index% eq 0%> (total)<%/if%></i></font><%/if%></tt></td></tr>");
	<%sectionelse%>
		_smarty_console.document.write("<tr bgcolor=#eeeeee><td colspan=2><tt><i>テンプレートファイルは読み込まれていません。</i></tt></td></tr>");	
	<%/section%>
	_smarty_console.document.write("<tr bgcolor=#cccccc><td colspan=2><b>プログラムからassignされているテンプレート変数:</b></td></tr>");
	<%section name=vars loop=$_debug_keys%>
		_smarty_console.document.write("<tr bgcolor=<%if %vars.index% is even%>#eeeeee<%else%>#fafafa<%/if%>><td valign=top><tt><font color=blue>{$<%$_debug_keys[vars]%>}</font></tt></td><td nowrap><tt><font color=green><%$_debug_vals[vars]|@debug_print_var|escape:javascript%></font></tt></td></tr>");
	<%sectionelse%>
		_smarty_console.document.write("<tr bgcolor=#eeeeee><td colspan=2><tt><i>何もassignされていません。</i></tt></td></tr>");	
	<%/section%>
	_smarty_console.document.write("<tr bgcolor=#cccccc><td colspan=2><b>コンフィグファイルからのテンプレート変数:</b></td></tr>");
	<%section name=config_vars loop=$_debug_config_keys%>
		_smarty_console.document.write("<tr bgcolor=<%if %config_vars.index% is even%>#eeeeee<%else%>#fafafa<%/if%>><td valign=top><tt><font color=maroon>{#<%$_debug_config_keys[config_vars]%>#}</font></tt></td><td><tt><font color=green><%$_debug_config_vals[config_vars]|@debug_print_var|escape:javascript%></font></tt></td></tr>");
	<%sectionelse%>
		_smarty_console.document.write("<tr bgcolor=#eeeeee><td colspan=2><tt><i>コンフィグファイルからのテンプレート変数はありません。</i></tt></td></tr>");	
	<%/section%>
	_smarty_console.document.write("</table>");
	_smarty_console.document.write("</BODY></HTML>");
	_smarty_console.document.close();
</SCRIPT>
<%/if%>