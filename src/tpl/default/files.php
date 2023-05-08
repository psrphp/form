<script>
    $(function() {
        $("#{$id}_field").bind('click', function() {
            $("#{$id}_container").html('');
            var val = $('#{$id}_field').val();
            var resizex = function(limit) {
                var size = "";
                if (limit < 0.1 * 1024) {
                    size = limit.toFixed(2) + "B"
                } else if (limit < 0.1 * 1024 * 1024) {
                    size = (limit / 1024).toFixed(2) + "KB"
                } else if (limit < 0.1 * 1024 * 1024 * 1024) {
                    size = (limit / (1024 * 1024)).toFixed(2) + "MB"
                } else {
                    size = (limit / (1024 * 1024 * 1024)).toFixed(2) + "GB"
                }

                var sizeStr = size + "";
                var index = sizeStr.indexOf(".");
                var dou = sizeStr.substr(index + 1, 2)
                if (dou == "00") {
                    return sizeStr.substring(0, index) + sizeStr.substr(index + 3, 2)
                }
                return size;
            };
            if (val) {
                var files = JSON.parse(val);
                $.each(files, function(index, obj) {
                    var html = "";
                    html += '<div class="input-group mb-3">';
                    html += '<a class="btn btn-secondary" href="' + obj.src + '" target="_blank">⇗</a>';
                    html += '<span class="input-group-text" style="width: 125px;">大小：' + resizex(obj.size) + '</span>';
                    html += '<span class="input-group-text">标题：</span>';
                    html += '<input type="text" class="_title form-control" name="{$name}[' + index + '][title]" value="' + obj.title + '" data-index="' + index + '" placeholder="请输入图片标题" aria-label="请输入标题">';
                    html += '<input type="hidden" name="{$name}[' + index + '][src]" value="' + obj.src + '">';
                    html += '<input type="hidden" name="{$name}[' + index + '][size]" value="' + obj.size + '">';
                    html += '<button class="_action btn btn-outline-secondary" type="button" data-index="' + index + '" data-step="0">x</button>';
                    if (index != 0) {
                        html += '<button class="_action btn btn-outline-secondary" type="button" data-index="' + index + '" data-step="-1">↑</button>';
                    }
                    if (index < files.length - 1) {
                        html += '<button class="_action btn btn-outline-secondary" type="button" data-index="' + index + '" data-step="1">↓</button>';
                    }
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
                        if (response.code == 0) {
                            callback(response);
                        } else {
                            alert(response.message);
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
            fileinput.onchange = function() {
                $.each(event.target.files, function(indexInArray, valueOfElement) {
                    upload_by_form("{$upload_url??''}", valueOfElement, function(response) {
                        if (response.code == 0) {
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
                        } else {
                            alert(response.message);
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
    <div class="d-flex flex-column mb-2" id="{$id}_container"></div>
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