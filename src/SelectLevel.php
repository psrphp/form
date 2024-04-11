<?php

declare(strict_types=1);

namespace PsrPHP\Form;

class SelectLevel extends Common
{
    public function __construct(string $label, string $name, $value = null, array $items = [])
    {
        $this->set('label', $label);
        $this->set('name', $name);
        $this->set('value', $value);
        $this->set('items', $items);
    }

    public function getTpl(): string
    {
        return <<<'str'
<div style="display: flex;flex-direction: row;gap: 5px;flex-wrap: wrap;">
    <input type="hidden" name="{$name}" value="{$value}">
</div>
<script>
    (function() {
        var items = JSON.parse('{echo json_encode($items)}');
        var container = document.currentScript.previousElementSibling;
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
            var _parent = event.target.parentNode.parentElement;
            var _child = _parent.children;
            for (var i = _child.length - 1; i >= 0; i--) {
                var _childI = _child[i];
                if (_childI == event.target.parentNode) {
                    break;
                }
                _childI.remove();
            }

            var value = event.target.value;
            var trueval = value;
            if (event.target.selectedIndex === 0) {
                if (event.target.parentNode.parentNode.children[1] !== event.target.parentNode) {
                    trueval = event.target.parentNode.previousElementSibling.children[0].value;
                }
            }
            event.target.parentNode.parentNode.children[0].value = trueval;
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
            select.onchange = changeSelect;
            var node = document.createElement("option");
            node.innerText = "不限";
            node.value = "";
            select.appendChild(node);

            var groups = {};
            for (const key in items) {
                if (Object.hasOwnProperty.call(items, key)) {
                    const ele = items[key];
                    if (ele.parent == parent) {
                        if (ele.group) {
                            if (!groups[ele.group]) {
                                groups[ele.group] = ele.group;
                                var optgroup = document.createElement("optgroup");
                                optgroup.label = ele.group;

                                for (const _k in items) {
                                    if (Object.hasOwnProperty.call(items, _k)) {
                                        const subele = items[_k];
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
                                    }
                                }
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
            }
            if (select.children.length > 1) {
                var div = document.createElement("div");
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
                for (const key in items) {
                    if (Object.hasOwnProperty.call(items, key)) {
                        const ele = items[key];
                        if (ele.value == findval) {
                            findval = ele.parent;
                            parents.unshift(ele);
                            find = true;
                            break;
                        }
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
                } else {
                    var select = document.createElement('select');
                    select.onchange = changeSelect;
                    var node = document.createElement("option");
                    node.innerText = "不限";
                    node.value = "";
                    select.appendChild(node);
                    var div = document.createElement("div");
                    div.append(select);
                    container.appendChild(div);
                }
            }
        }
        initSelect(container.children[0].value);
    })()
</script>
str;
    }
}
