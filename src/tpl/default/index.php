<!DOCTYPE html>
<html lang="{$options['lang'] ?? 'zh-CN'}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title ?: '表单'}</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.x/dist/jquery.min.js"></script>
</head>

<body>
    <div>
        <form action="{$action?:''}" method="{$method?:'POST'}" enctype="{$options['enctype']??'application/x-www-form-urlencoded'}" id="form">
            <h1>{$title?:'表单'}</h1>
            <div style="display: flex;flex-direction: column;gap: 10px;">
                {echo $body}
            </div>
            <div style="margin-top: 20px;">
                <button type="submit">{$options['submit'] ?? '提交'}</button>
            </div>
        </form>
    </div>

    <script>
        (function() {
            var form = document.getElementById("form");
            form.onsubmit = function() {
                event.preventDefault();
                $.ajax({
                    type: event.target.method,
                    url: event.target.action,
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        alert(response.message);
                        if (!response.errcode) {
                            window.history.go(-1);
                        }
                    },
                    error: function(response, b, c) {
                        alert("[" + response.status + "] " + response.responseText);
                    }
                });
            }
        })()
    </script>
</body>

</html>