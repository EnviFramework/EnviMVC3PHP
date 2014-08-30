
<input type="hidden" name="<%name%>" value="<%$default%>">
<%if $type == 'textarea'%>
<div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$default|nl2br%>
</div>
<%else%>
<div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$default%>
</div>
<%/if%>

