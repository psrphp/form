<!DOCTYPE html>
<html lang="{$options['lang'] ?? 'zh-CN'}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title ?: '表单'}</title>
    <style>
        a {
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 5px;
        }

        fieldset {
            border-width: 1px;
            border-color: #888;
        }

        fieldset legend {
            font-weight: bold;
        }

        select,
        input,
        textarea {
            padding: 2px;
        }
    </style>
</head>

<body>
    <form action="{$action?:''}" method="{$method?:'POST'}" enctype="{$options['enctype']??'application/x-www-form-urlencoded'}" id="form">
        <h1>{$title?:'表单'}</h1>
        <div style="display: flex;flex-direction: column;gap: 10px;">
            {echo $body}
        </div>
        <div style="margin-top: 20px;">
            <button type="submit">{$options['submit'] ?? '提交'}</button>
        </div>
    </form>

    <script>
        (function() {
            var form = document.getElementById("form");
            form.onsubmit = function() {
                event.preventDefault();
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open(event.target.method, event.target.action, true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.setRequestHeader("Accept", "application/json");
                xmlhttp.responseType = "json";
                xmlhttp.onerror = function(e) {};
                xmlhttp.ontimeout = function(e) {
                    alert("超时");
                };
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4) {
                        if (xmlhttp.status == 200) {
                            alert(xmlhttp.response.message);
                            if (!xmlhttp.response.errcode) {
                                window.history.go(-1);
                            }
                        } else {
                            alert("[" + xmlhttp.status + "] " + xmlhttp.statusText);
                        }
                    }
                }
                let obj = Object.fromEntries(new FormData(form));
                let params = new URLSearchParams();
                for (let key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        params.set(key, obj[key])
                    }
                }
                xmlhttp.send(params.toString());
            }
        })()
    </script>
</body>

</html>