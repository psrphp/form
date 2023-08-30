# 表单生成器

生成表单

## 安装

``` bash
composer require psrphp/form
```

## 用例

``` php
use PsrPHP\Form\Builder;
use PsrPHP\Form\Col;
use PsrPHP\Form\Row;
use PsrPHP\Form\Checkbox;
use PsrPHP\Form\Code;
use PsrPHP\Form\Cover;
use PsrPHP\Form\Files;
use PsrPHP\Form\Input;
use PsrPHP\Form\Pics;
use PsrPHP\Form\Radio;
use PsrPHP\Form\Select;
use PsrPHP\Form\SimpleMDE;
use PsrPHP\Form\Summernote;
use PsrPHP\Form\Switchs;
use PsrPHP\Form\Textarea;

$builder = new Builder('表单');
$builder->addItem(
    new Row(
        (new Col('col-md-3'))->addItem(
            (new Input('单行文本', '字段1', '默认值')),
            (new Select('下拉选择', '字段2', '默认值'))->set('items', ['选项一', '选项二']),
            (new Checkbox('多选框', '字段3', ['选中值']))->set('items', ['选中值', '可选值2']),
            (new Radio('单选', '字段4', '选中值'))->set('items', ['选中值', '可选值2', '可选值3']),
            (new SimpleMDE('Markdown编辑器', '字段5', '# 我是标题')),
            (new Summernote('富文本编辑器', '字段6', '我是默认值')),
            (new Textarea('多行文本', '字段7', '我是多行文本默认值'))
        ),
        (new Col('col-md-9'))->addItem(
            (new Code('代码编辑框', 'codex', '我是值')),
            (new Cover('单图上传', 'cover', 'http://....jpg')),
            (new Files('多文件上传', 'asdfas', [])),
            (new Pics('多图片上传', 'asdfas', [])),
            (new Switchs('选项切换', 'switch', 'dww'))->addSwitch('kkj', 'sd', 'adfsdf')->addSwitch('sdfsdf', 'dww', 'asdf')
        ),
    ),
    new Input('另一个单行文本', 'FES', 'DFS')
);

echo $builder;
```
