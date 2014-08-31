
<%if $type == 'textarea'%>
  <div class="form-group">
  <label for="form_<%$name%>"><%$form_name%></label>
  <textarea type="<%$type%>" name="<%$name%>" class="form-control" id="form_<%$name%>" placeholder="<%$form_name%>"><%$default%></textarea>
  </div>
<%elseif $type == 'select'%>
  <div class="form-group">
  <label for="form_<%$name%>"><%$form_name%></label>
  <select name="<%$name%>" id="form_<%$name%>">
    <%html_options selected=$default options=$options%>
  </select>
  </div>
<%elseif $type == 'radio'%>
  <div class="form-group">
  <label for="form_<%$name%>"><%$form_name%></label>
  <%html_radios name=$name selected=$default options=$options%>
  </div>
<%elseif $type == 'checkbox'%>
  <div class="form-group">
  <label for="form_<%$name%>"><%$form_name%></label>
  <%html_checkboxes name="`$name`[]" selected=$default options=$options%>
  </div>
<%elseif $type == 'flag'%>
  <div class="form-group">
  <label for="form_<%$name%>"><%$form_name%></label>
  <input type="checkbox" name="<%$name%>" value="1"<%if $default%> checked="checked"<%/if%>>
  </div>
<%else%>
  <div class="form-group">
  <label for="form_<%$name%>"><%$form_name%></label>
  <input type="<%$type%>" name="<%$name%>" class="form-control" id="form_<%$name%>" placeholder="<%$form_name%>" value="<%$default%>">
  </div>
<%/if%>
