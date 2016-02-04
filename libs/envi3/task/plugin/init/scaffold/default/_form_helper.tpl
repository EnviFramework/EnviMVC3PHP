<div class="form-group<%if $error && $error.keys.$name && $custom_error !== false%> has-error<%/if%>">
<%if $type == 'textarea'%>
  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
  <textarea type="<%$type%>" name="<%$name%>" class="form-control<%if $class%> <%$class%><%/if%>" id="form_<%$name%>" placeholder="<%$form_name%>" rows="<%$rows|default:3%>"<%if $required%> required<%/if%>><%$smarty.post.$name|default:$default%></textarea>

<%elseif $type == 'datetime'%>
  <%assign var="datetime_date_key" value="`$name`_date"%>
  <%assign var="datetime_time_key" value="`$name`_time"%>
  <%assign var="datetime_date_default" value=$default|substr:0:10%>
  <%assign var="datetime_time_default" value=$default|substr:-8:5%>

  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
  <input type="date" name="<%$name%>_date" id="form_<%$name%>"<%if $class%> class="<%$class%>"<%/if%> value="<%$smarty.post.$datetime_date_key|default:$datetime_date_default%>"<%if $required%> required<%/if%>>
  <input type="time" name="<%$name%>_time" id="form_<%$name%>"<%if $class%> class="<%$class%>"<%/if%> value="<%$smarty.post.$datetime_time_key|default:$datetime_time_default%>"<%if $required%> required<%/if%>>

<%elseif $type == 'date'%>
  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
  <input type="date" name="<%$name%>" class="form-control<%if $class%> <%$class%><%/if%>" id="form_<%$name%>" placeholder="<%$form_name%>" value="<%$smarty.post.$name|default:$default%>"<%if $required%> required<%/if%>>

<%elseif $type == 'time'%>
  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
  <input type="time" name="<%$name%>" class="form-control<%if $class%> <%$class%><%/if%>" id="form_<%$name%>" placeholder="<%$form_name%>" value="<%$smarty.post.$name|default:$default%>"<%if $required%> required<%/if%>>

<%elseif $type == 'select'%>
  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
  <select name="<%$name%>" id="form_<%$name%>" class="form-control<%if $class%> <%$class%><%/if%>"<%if $required%> required<%/if%>>
    <%html_options selected=$smarty.post.$name|default:$default options=$options%>
  </select>

<%elseif $type == 'radio'%>
  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
  <div class="form-group">
  <%html_radios name=$name selected=$smarty.post.$name|default:$default options=$options separator=$separator|default:""%>
  </div>

<%elseif $type == 'checkbox'%>
  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
  <div class="form-group">
  <%html_checkboxes name="`$name`[]" selected=$smarty.post.$name|default:$default options=$options separator=$separator|default:""%>
  </div>

<%elseif $type == 'flag'%>
  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
  <input type="checkbox" name="<%$name%>" id="form_<%$name%>"<%if $class%> class="<%$class%>"<%/if%> value="1"<%if $default || $smarty.post.$name%> checked="checked"<%/if%>>

<%elseif $type == 'zip_code'%>
  <%assign var="zip_code_f_key" value="`$name`_f"%>
  <%assign var="zip_code_a_key" value="`$name`_a"%>
  <%assign var="zip_code_f_default" value=$default|substr:0:3%>
  <%assign var="zip_code_a_default" value=$default|substr:-4:4%>

  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
    <div class="row">
      <div class="col-xs-3">
      <input type="text" name="<%$name%>_f" class="form-control<%if $class%> <%$class%><%/if%>" id="form_<%$name%>_first" placeholder="<%$form_name_f%>" value="<%$smarty.post.$zip_code_f_key|default:$zip_code_f_default%>" size="3"<%if $required%> required<%/if%>>
      </div>
      <div class="col-xs-1">
      -
      </div>
      <div class="col-xs-4">
      <input type="text" name="<%$name%>_a" class="form-control<%if $class%> <%$class%><%/if%>" id="form_<%$name%>_last" placeholder="<%$form_name_a%>" value="<%$smarty.post.$zip_code_a_key|default:$zip_code_a_default%>" size="4"<%if $required%> required<%/if%>>
      </div>
    </div>

<%else%>
  <%if !$hidden_label%>
  <label for="form_<%$name%>"><%$form_name%><%if $required%><span class="label label-danger"><%$required_text|default:"必須"%></span><%/if%></label>
  <%/if%>
  <input type="<%$type%>" name="<%$name%>" class="form-control<%if $class%> <%$class%><%/if%>" id="form_<%$name%>" placeholder="<%$form_name%>" value="<%$smarty.post.$name|default:$default%>"<%if $required%> required<%/if%>>

<%/if%>
  <%if $error && $error.keys.$name && $custom_error !== false%>
    <ul class="error_sub_message">
      <%foreach from=$error.keys.$name key=key item=item name=error_sub_message%>
        <li><%$error.message.$item%></li>
      <%/foreach%>
    </ul>
  <%/if%>

  <%if $help%>
    <span class="help-block"><%$help%></span>
  <%/if%>
</div>
