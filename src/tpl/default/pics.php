<?php $_id = uniqid('f_'); ?>
<input type="hidden" value="{:json_encode($value)}" id="{$_id}_field">
<div id="{$_id}_container" style="display: flex;flex-direction: row;gap: 5px;flex-wrap: wrap;"></div>
<div style="margin-top: 5px;">
    <button type="button" id="{$_id}_handler">{$upload_text??'上传'}</button>
</div>
<script>
    (function() {
        var container = document.getElementById("{$_id}_container");
        var handler = document.getElementById("{$_id}_handler");
        var upload_url = "{$upload_url??''}";
        var pics = JSON.parse('{echo json_encode($value)}');

        function renderValue() {
            container.innerHTML = "";
            for (const index in pics) {
                if (Object.hasOwnProperty.call(pics, index)) {
                    const obj = pics[index];

                    var div = document.createElement("div");
                    div.style.display = "flex";
                    div.style.flexDirection = "column";
                    div.style.gap = "5px";
                    div.style.flexWrap = "wrap";
                    container.appendChild(div);

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

                    var imgdiv = document.createElement("div");
                    imgdiv.style.width = "145px";
                    imgdiv.style.height = "100px";
                    imgdiv.style.display = "flex"
                    imgdiv.style.flexDirection = "row"
                    imgdiv.style.justifyContent = "center"
                    imgdiv.style.alignItems = "center"
                    imgdiv.style.background = "#eee"
                    imgdiv.style.padding = "5px"
                    div.appendChild(imgdiv)

                    var img = document.createElement("img");
                    img.style.maxHeight = "100%"
                    img.style.maxWidth = "100%"
                    img.alt = obj.src
                    img.title = obj.src
                    img.src = obj.src
                    imgdiv.appendChild(img)

                    var inputtitle = document.createElement("input");
                    inputtitle.type = "text";
                    inputtitle.name = "{$name}[" + index + "][title]";
                    inputtitle.value = obj.title;
                    inputtitle.placeholder = "请输入图片标题";
                    inputtitle.onchange = function() {
                        pics[index]['title'] = event.target.value;
                    }
                    div.appendChild(inputtitle);

                    var actiondiv = document.createElement("div")
                    actiondiv.style.display = "flex"
                    actiondiv.style.gap = "5px"
                    div.appendChild(actiondiv);

                    var delbtn = document.createElement("button");
                    delbtn.type = "button";
                    delbtn.innerText = "删除";
                    delbtn.onclick = function() {
                        if (confirm('确定删除吗?')) {
                            pics.splice(index, 1);
                            renderValue();
                        }
                    }
                    actiondiv.appendChild(delbtn);

                    if (index != 0) {
                        var upbtn = document.createElement("button");
                        upbtn.type = "button";
                        upbtn.innerText = "上移";
                        upbtn.onclick = function() {
                            pics[index] = pics.splice(parseInt(index) - 1, 1, pics[index])[0];
                            renderValue();
                        }
                        actiondiv.appendChild(upbtn);
                    }

                    if (index < pics.length - 1) {
                        var downbtn = document.createElement("button");
                        downbtn.type = "button";
                        downbtn.innerText = "下移";
                        downbtn.onclick = function() {
                            pics[index] = pics.splice(parseInt(index) + 1, 1, pics[index])[0];
                            renderValue();
                        }
                        actiondiv.appendChild(downbtn);
                    }
                }
            }
        }

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
            fileinput.accept = "image/*";
            fileinput.onchange = function() {
                var items = event.target.files;
                for (const indexInArray in items) {
                    if (Object.hasOwnProperty.call(items, indexInArray)) {
                        const valueOfElement = items[indexInArray];
                        upload_by_form(upload_url, valueOfElement, function(response) {
                            if (response.errcode) {
                                alert(response.message);
                            } else {
                                pics.push({
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

        setTimeout(function() {
            renderValue();
        }, 100);
    })()
</script>