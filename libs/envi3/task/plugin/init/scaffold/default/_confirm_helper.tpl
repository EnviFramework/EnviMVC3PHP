<%if $type == 'textarea'%>
  <input type="hidden" name="<%$name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$default|nl2br%>
  </div>
<%elseif $type == 'date'%>
  <input type="hidden" name="<%$name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$options[$default]%>
  </div>

<%elseif $type == 'time'%>
  <input type="hidden" name="<%$name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$options[$default]%>
  </div>

<%elseif $type == 'datetime'%>
  <input type="hidden" name="<%$name%>_date" value="<%$default|substr:0:10%>">
  <input type="hidden" name="<%$name%>_time" value="<%$default|substr:-8:5%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$default|substr:0:16%>
  </div>


<%elseif $type == 'select'%>
  <input type="hidden" name="<%$name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$options[$default]%>
  </div>
<%elseif $type == 'radio'%>
  <input type="hidden" name="<%$name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$options[$default]%>
  </div>
<%elseif $type == 'checkbox'%>
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%foreach from=$default key=key item=item%>
      <input type="hidden" name="<%$name%>[]" value="<%$item%>">
      <%$options[$item]%>
    <%/foreach%>
  </div>
<%elseif $type == 'flag'%>
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%if $default == 1%>
    <%$options.1|default:"はい"%>
    <input type="hidden" name="<%$name%>" value="1">
    <%else%>
    <%$options.0|default:"いいえ"%>
    <%/if%>
  </div>
<%elseif $type == 'zip_code'%>
  <input type="hidden" name="<%$name%>_f" value="<%$default|substr:0:3%>">
  <input type="hidden" name="<%$name%>_a" value="<%$default|substr:-4:4%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$default%>
  </div>
<%else%>
  <input type="hidden" name="<%$name%>" value="<%$default%>">
  <div class="form-group">
    <label for="form_<%$name%>"><%$form_name%></label>
    <%$default%>
  </div>
<%/if%>

