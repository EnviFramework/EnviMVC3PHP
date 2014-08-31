
<%if $type == 'textarea'%>
  <input type="hidden" name="<%name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$default|nl2br%>
  </div>
<%elseif $type == 'select'%>
  <input type="hidden" name="<%name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$options[$default]%>
  </div>
<%elseif $type == 'radio'%>
  <input type="hidden" name="<%name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$options[$default]%>
  </div>
<%elseif $type == 'checkbox'%>
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%foreach from=$default key=key item=item%>
      <input type="hidden" name="<%name%>[]" value="<%$item%>">
      <%$options[$item]%>
    <%/foreach%>
  </div>
<%elseif $type == 'flag'%>
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%if $default == 1%>
    <%$options.1|default:"はい"%>
    <input type="hidden" name="<%name%>" value="1">
    <%else%>
    <%$options.0|default:"いいえ"%>
    <%/if%>
  </div>
<%else%>
  <input type="hidden" name="<%name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$default%>
  </div>
<%/if%>

