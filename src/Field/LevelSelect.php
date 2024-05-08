<?php

declare(strict_types=1);

namespace PsrPHP\Form\Field;

use PsrPHP\Form\ItemInterface;

class LevelSelect implements ItemInterface
{
    private $label = '';
    private $name = '';
    private $value = '';

    private $help = '';

    private $items = [];

    public function __construct(string $label, string $name, string $value = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }

    public function addItem(string $title, string $value, string $parent = '', string $group = '', bool $disabled = false): self
    {
        array_push($this->items, [
            'title' => $title,
            'value' => $value,
            'parent' => $parent,
            'group' => $group,
            'disabled' => $disabled,
        ]);
        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        $str .= '<label class="form-label">' . htmlspecialchars($this->label) . '</label>';

        $name = htmlspecialchars($this->name);
        $value = htmlspecialchars($this->value);
        $items = json_encode($this->items, JSON_UNESCAPED_UNICODE);
        $str .= <<<str
<div style="display: flex;flex-direction: row;gap: 5px;flex-wrap: wrap;">
    <input type="hidden" name="{$name}" value="{$value}">
</div>
<script>
    (function() {
        var items = JSON.parse('{$items}');
        var container = document.currentScript.previousElementSibling;

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
            select.className = "form-select";
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
                } else { // 以下可能无效
                    var select = document.createElement('select');
                    select.className = "form-select";
                    select.onchange = changeSelect;
                    var node = document.createElement("option");
                    node.innerText = "不限1";
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
        if (strlen($this->help)) {
            $str .= '<div class="form-text">' . htmlspecialchars($this->help) . '</div>';
        }
        return $str;
    }
}
