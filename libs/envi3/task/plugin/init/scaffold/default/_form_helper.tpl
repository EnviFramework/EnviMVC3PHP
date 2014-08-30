
<%if $type == 'textarea'%>
<div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <textarea type="<%$type%>" name="<%$name%>" class="form-control" id="form_<%$name%>" placeholder="<%$form_name%>"><%$default%></textarea>
</div>
<%else%>
<div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <input type="<%$type%>" name="<%$name%>" class="form-control" id="form_<%$name%>" placeholder="<%$form_name%>" value="<%$default%>">
</div>
<%/if%>
