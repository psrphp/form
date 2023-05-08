<script src="https://cdn.jsdelivr.net/npm/holderjs@2.9.6/holder.min.js"></script>
<div class="mt-2">
    <label for="{$id}_field" class="form-label">{$label}</label>
    <input type="text" class="form-control d-none" name="{$name}" value="{$value}" id="{$id}_field">
    <style>
        .xcover:hover>.position-absolute {
            display: block !important;
        }
    </style>
    <div class="position-relative xcover" style="min-height: 100px;">
        <img style="cursor:pointer;max-height:200px;max-width:200px;" class="img-thumbnail img-fluid" data-src="holder.js/300x200?auto=yes&text=click%20upload&size=25" id="{$id}_handler">
        <div class="position-absolute bg-secondary text-white rounded-circle text-center" id="{$id}_close" style="width:25px;height:25px;left:10px;top:10px;cursor:pointer;display:none;">&times;</div>
    </div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                if ($("#{$id}_field").val()) {
                    $("#{$id}_handler").attr("src", $("#{$id}_field").val());
                }
            }, 100);
            $("#{$id}_handler").bind("click", function() {
                var upload_by_form = function(url, file, callback) {
                    var data = new FormData();
                    data.append("file", file);
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
                            alert("Error");
                        }
                    });
                }
                var fileinput = document.createElement("input");
                fileinput.type = "file";
                fileinput.onchange = function() {
                    $.each(event.target.files, function(indexInArray, valueOfElement) {
                        upload_by_form("{$upload_url??''}", valueOfElement, function(response) {
                            if (response.code == 0) {
                                $("#{$id}_handler").attr("src", response.data.src);
                                $("#{$id}_field").val(response.data.src);
                            } else {
                                alert(response.message);
                            }
                        });
                    });
                }
                fileinput.click();
            });
            $("#{$id}_close").bind("click", function() {
                $("#{$id}_handler").attr("data-src", "holder.js/300x200?auto=yes&text=click%20upload&size=25");
                Holder.run({
                    images: document.getElementById("{$id}_handler")
                });
                $("#{$id}_field").val("");
            });
        });
    </script>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>