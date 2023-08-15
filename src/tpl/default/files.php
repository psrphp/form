<?php $_id = uniqid('f_'); ?>
<div id="{$_id}_container" style="display: flex;flex-direction: column;gap: 5px;"></div>
<div style="margin-top: 5px;">
    <button type="button" id="{$_id}_handler">{$upload_text??'上传'}</button>
</div>
<script>
    (function() {
        var container = document.getElementById("{$_id}_container");
        var handler = document.getElementById("{$_id}_handler");
        var upload_url = "{$upload_url??''}";
        var files = JSON.parse('{echo json_encode($value)}');

        function sizex(limit) {
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
        }

        function renderValue() {
            container.innerHTML = "";
            for (const index in files) {
                if (Object.hasOwnProperty.call(files, index)) {
                    const obj = files[index];

                    var div = document.createElement("div");
                    div.style.display = "flex";
                    div.style.flexDirection = "row";
                    div.style.gap = "5px";

                    var inputsrc = document.createElement("input");
                    inputsrc.type = "hidden";
                    inputsrc.name = "{$name}[" + index + "][src]";
                    inputsrc.value = obj.src;
                    div.appendChild(inputsrc);

                    var inputsize = document.createElement("input");
                    inputsize.type = "hidden";
                    inputsize.name = "{$name}[" + index + "][size]";
                    inputsize.value = obj.size;
                    div.appendChild(inputsize);

                    var delbtn = document.createElement("button");
                    delbtn.type = "button";
                    delbtn.innerText = "删除";
                    delbtn.onclick = function() {
                        if (confirm('确定删除吗?')) {
                            files.splice(index, 1);
                            renderValue();
                        }
                    }
                    div.appendChild(delbtn);

                    if (index != 0) {
                        var upbtn = document.createElement("button");
                        upbtn.type = "button";
                        upbtn.innerText = "上移";
                        upbtn.onclick = function() {
                            files[index] = files.splice(parseInt(index) - 1, 1, files[index])[0];
                            renderValue();
                        }
                        div.appendChild(upbtn);
                    }

                    if (index < files.length - 1) {
                        var downbtn = document.createElement("button");
                        downbtn.type = "button";
                        downbtn.innerText = "下移";
                        downbtn.onclick = function() {
                            files[index] = files.splice(parseInt(index) + 1, 1, files[index])[0];
                            renderValue();
                        }
                        div.appendChild(downbtn);
                    }

                    var inputtitle = document.createElement("input");
                    inputtitle.type = "text";
                    inputtitle.name = "{$name}[" + index + "][title]";
                    inputtitle.value = obj.title;
                    inputtitle.placeholder = "请输入图片标题";
                    inputtitle.onchange = function() {
                        files[index]['title'] = event.target.value;
                    }
                    div.appendChild(inputtitle);

                    var span = document.createElement("span");
                    span.innerText = sizex(obj.size);
                    div.appendChild(span);

                    // var a = document.createElement("a");
                    // a.href = obj.src;
                    // a.target = "_blank";
                    // a.innerText = "预览";
                    // div.appendChild(a);

                    container.appendChild(div);
                }
            }
        }

        setTimeout(function() {
            renderValue();
        }, 100);

        handler.onclick = function() {
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
            fileinput.onchange = function() {
                var items = event.target.files;
                for (const indexInArray in items) {
                    if (Object.hasOwnProperty.call(items, indexInArray)) {
                        const valueOfElement = items[indexInArray];
                        upload_by_form(upload_url, valueOfElement, function(response) {
                            if (response.errcode) {
                                alert(response.message);
                            } else {
                                files.push({
                                    src: response.data.src,
                                    size: response.data.size,
                                    title: response.data.filename,
                                });
                                renderValue();
                            }
                        });
                    }
                }
            }
            fileinput.click();
        }
    })()
</script>