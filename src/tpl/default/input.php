<div class="mt-2">
    <label for="{$id}_field" class="form-label">{$label}</label>
    <input type="{$type??'text'}" name="{$name}" value="{$value}" id="{$id}_field" class="form-control" list="{$id}_datalist" <?php if (isset($required) && $required) { ?>required<?php } ?> <?php if (isset($disabled) && $disabled) { ?>disabled<?php } ?> <?php if (isset($readonly) && $readonly) { ?>readonly<?php } ?>>
    <datalist id="{$id}_datalist">
        {if isset($datalist) && is_array($datalist)}
        {foreach $datalist as $_k => $_vo}
        <option value="{$_k}">{$_vo}</option>
        {/foreach}
        {/if}
    </datalist>
    {if isset($dataurl)}
    <script>
        $(function() {
            $("#{$id}_field").on('input', function() {
                $.ajax({
                    type: "GET",
                    url: "{$dataurl}",
                    data: {
                        q: $("#{$id}_field").val(),
                    },
                    dataType: "JSON",
                    success: function(response) {
                        var options = '';
                        if (!response.errcode) {
                            $.each(response.data, function(indexInArray, valueOfElement) {
                                options += "<option value=\"" + indexInArray + "\">" + valueOfElement + "</option>";
                            });
                        }
                        $("#{$id}_datalist").html(options);
                    }
                });
            });
        });
    </script>
    {/if}
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>