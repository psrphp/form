<!DOCTYPE html>
<html lang="{$options['lang'] ?? 'zh-CN'}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title ?: '表单'}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.x/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.x/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.x/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .form-label {
            font-weight: bold;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="{$action?:''}" method="{$method?:'POST'}" enctype="{$options['enctype']??'application/x-www-form-urlencoded'}" id="form">
            <div class="my-4">
                <div class="h1">{$title?:'表单'}</div>
            </div>
            <div class="my-3">
                {echo $body}
            </div>
            <div class="py-3">
                <button type="submit" class="btn btn-primary btn px-4">{$options['submit'] ?? '提交'}</button>
            </div>
        </form>
    </div>

    <script>
        $(function() {
            $("#form").bind('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        alert(response.message);
                        if (response.code == 0) {
                            window.history.go(-1);
                        }
                    },
                    error: function(response, b, c) {
                        alert("[" + response.status + "] " + response.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>

</html>