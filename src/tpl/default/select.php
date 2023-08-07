<div class="mt-2">
    <label for="{$id}_field" class="form-label">{$label}</label>
    <div class="d-flex flex-row" id="{$id}_field">
        <input type="hidden" name="{$name}" value="{$value}">
    </div>
    {if isset($help) && $help}
    <div class="form-text text-muted" style="font-size: .8em;">{echo $help}</div>
    {/if}
</div>
<script>
    (function() {
        var items = JSON.parse('{echo json_encode($items)}');
        var container = document.getElementById("{$id}_field");
        for (const key in items) {
            if (Object.hasOwnProperty.call(items, key)) {
                const item = items[key];
                if (typeof item === 'object') {
                    items[key] = {
                        value: String(item.value == undefined ? '' : item.value),
                        parent: String(item.parent == undefined ? '' : item.parent),
                        title: String(item.title == undefined ? '' : item.title),
                        group: String(item.group == undefined ? '' : item.group),
                        disabled: item.disabled ? true : false,
                    }
                } else {
                    items[key] = {
                        value: String(item == undefined ? '' : item),
                        title: String(item == undefined ? '' : item),
                        parent: '',
                        group: '',
                        disabled: item.disabled ? true : false,
                    }
                }
            }
        }

        function changeSelect() {
            $(event.target.parentNode).nextAll().remove();
            var value = event.target.value;
            var trueval = value;
            if (event.target.selectedIndex === 0) {
                if (event.target.parentNode.parentNode.childNodes[3] !== event.target.parentNode) {
                    trueval = event.target.parentNode.previousElementSibling.childNodes[0].value;
                }
            }
            event.target.parentNode.parentNode.childNodes[1].value = trueval;
            if (value != undefined && value != '') {
                var select = buildSelect(value);
                if (select) {
                    event.target.parentNode.parentNode.appendChild(select);
                }
            }
        }

        function buildSelect(parent, selectvalue) {
            parent = parent == undefined ? '' : parent;
            var select = document.createElement('select');
            select.className = "form-select";
            select.onchange = changeSelect;
            var node = document.createElement("option");
            node.innerText = "不限";
            node.value = "";
            select.appendChild(node);

            var groups = {};
            for (let index = 0; index < items.length; index++) {
                const ele = items[index];
                if (ele.parent == parent) {
                    if (ele.group) {
                        if (!groups[ele.group]) {
                            groups[ele.group] = ele.group;
                            var optgroup = document.createElement("optgroup");
                            optgroup.label = ele.group;
                            items.forEach(subele => {
                                if (subele.parent == parent) {
                                    if (subele.group == ele.group) {
                                        var node = document.createElement("option");
                                        node.value = subele.value;
                                        node.innerText = subele.title ? subele.title : subele.value;
                                        if (node.value == selectvalue) {
                                            node.selected = "selected";
                                        }
                                        if (subele.disabled) {
                                            node.disabled = "disabled";
                                        }
                                        optgroup.appendChild(node);
                                    }
                                }
                            });
                            select.appendChild(optgroup);
                        }
                    } else {
                        var node = document.createElement("option");
                        node.value = ele.value;
                        node.innerText = ele.title ? ele.title : ele.value;
                        if (node.value == selectvalue) {
                            node.selected = 'selected';
                        }
                        if (ele.disabled) {
                            node.disabled = "disabled";
                        }
                        select.appendChild(node);
                    }
                }
            }
            if (select.childNodes.length > 1) {
                var div = document.createElement("div");
                div.className = "me-2";
                div.append(select);
                return div;
            }
            return;
        }

        function initSelect(value) {
            value = value == undefined ? '' : value;
            var parents = [];
            var findval = value;
            while (true) {
                var find;
                for (let index = 0; index < items.length; index++) {
                    const ele = items[index];
                    if (ele.value == findval) {
                        findval = ele.parent;
                        parents.unshift(ele);
                        find = true;
                        break;
                    }
                }
                if (!findval || !find) {
                    break;
                }
            }

            if (parents.length) {
                for (let index = 0; index < parents.length; index++) {
                    var ele = parents[index];
                    var sel = buildSelect(ele.parent, ele.value);
                    container.appendChild(sel);
                }
                var select = buildSelect(value);
                if (select) {
                    container.appendChild(select);
                }
            } else {
                var select = buildSelect();
                if (select) {
                    container.appendChild(select);
                }
            }
        }
        initSelect(container.childNodes[1].value);
    })()
</script>
