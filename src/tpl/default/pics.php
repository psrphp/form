<style>
    .ximg:hover .position-absolute {
        display: block !important;
    }
</style>
<script>
    $(function() {
        $("#{$id}_field").bind('click', function() {
            $("#{$id}_container").html('');
            var val = $('#{$id}_field').val();
            if (val) {
                var pics = JSON.parse(val);
                $.each(pics, function(index, obj) {
                    var html = "";
                    html += '<div class="position-relative ximg mr-2 mb-2">';
                    html += '<input type="hidden" name="{$name}[' + index + '][src]" value="' + obj.src + '">';
                    html += '<input type="hidden" name="{$name}[' + index + '][size]" value="' + obj.size + '">';
                    html += '<img style="cursor:pointer;height:200px;width:200px;" class="img-thumbnail img-fluid" alt="' + obj.src + '" title="' + obj.src + '" src="' + obj.src + '" >';
                    html += '<div class="position-absolute" style="left:10px;top:10px;right:0;display:none;">';
                    html += '<span class="_action text-white bg-secondary d-inline-block rounded-circle text-center mr-1" style="width:25px;height:25px;cursor:pointer;" data-index="' + index + '" data-step="0">×</span>';
                    if (index != 0) {
                        html += '<span class="_action text-white bg-secondary d-inline-block rounded-circle text-center mr-1" style="width:25px;height:25px;cursor:pointer;"data-index="' + index + '" data-step="-1">←</span>';
                    }
                    if (index < pics.length - 1) {
                        html += '<span class="_action text-white bg-secondary d-inline-block rounded-circle text-center mr-1" style="width:25px;height:25px;cursor:pointer;" data-index="' + index + '" data-step="1">→</span>';
                    }
                    html += '</div>';
                    html += '<textarea class="_title form-control mt-1" name="{$name}[' + index + '][title]" placeholder="请输入图片标题" data-index="' + index + '">' + obj.title + '</textarea>';
                    html += '</div>';
                    $("#{$id}_container").append(html);
                });

                $("#{$id}_container ._action").bind('click', function() {
                    var index = $(this).data('index');
                    var step = $(this).data('step');

                    var val = $('#{$id}_field').val();
                    arr = JSON.parse(val);

                    if (step == '0') {
                        if (confirm("确定删除吗？")) {
                            arr.splice(index, 1);
                        }
                    } else {
                        arr[index] = arr.splice(index + step, 1, arr[index])[0];
                    }

                    $('#{$id}_field').val(JSON.stringify(arr));
                    $("#{$id}_field").trigger('click');
                });
                $("#{$id}_container ._title").bind('change', function() {
                    var index = $(this).data('index');

                    var val = $('#{$id}_field').val();
                    arr = JSON.parse(val);

                    arr[index]['title'] = $(this).val();

                    $('#{$id}_field').val(JSON.stringify(arr));
                    $("#{$id}_field").trigger('click');
                });
            }
        });
        $("#{$id}_handle").bind('click', function() {
            var upload_by_form = function(url, file, callback) {
                var data = new FormData();
                data.append('file', file);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.errcode) {
                            alert(response.message);
                        } else {
                            callback(response);
                        }
                    },
                    error: function() {
                        alert('Error');
                    }
                });
            }
            var fileinput = document.createElement("input");
            fileinput.type = "file";
            fileinput.multiple = "multiple";
            fileinput.accept = "image/*";
            fileinput.onchange = function() {
                $.each(event.target.files, function(indexInArray, valueOfElement) {
                    upload_by_form("{$upload_url??''}", valueOfElement, function(response) {
                        if (response.errcode) {
                            alert(response.message);
                        } else {
                            var val = $('#{$id}_field').val();
                            if (val) {
                                arr = JSON.parse(val);
                            } else {
                                arr = [];
                            }
                            arr.push({
                                src: response.data.src,
                                size: response.data.size,
                                title: response.data.filename,
                            });
                            $('#{$id}_field').val(JSON.stringify(arr));
                            $("#{$id}_field").trigger('click');
                        }
                    });
                });
            }
            fileinput.click();
        });
    });
</script>
<div class="mt-2">
    <label for="{$id}_field" class="form-label">{$label}</label>
    <input type="hidden" value="{:json_encode($value)}" id="{$id}_field">
    <div class="d-flex flex-warp mb-2" id="{$id}_container"></div>
    <div>
        <button type="button" class="btn btn-secondary btn-sm" id="{$id}_handle">{$upload_text??'上传'}</button>
    </div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#{$id}_field").trigger('click');
            }, 100);
        });
    </script>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>