<?php

use yii\helpers\Url;
use yii\web\View;

$this->title = '生成二维码';
$css = <<<CSS
  .wrapper1 {position: relative;background-color: #F5F5F5;padding:0px 20px 20px 0px;margin-top:10px;}
   #input {position: absolute;top: 0;left: 0;opacity: 0;z-index: -10;}
  button{
    position: absolute;;
    top:0px;
    right:0px;
  }
CSS;

$js = <<<JS
    function copyText() {
      var text = document.getElementById("url").innerText;
      var input = document.getElementById("input");
      input.value = text; // 修改文本框的内容
      input.select(); // 选中文本
      document.execCommand("copy"); // 执行浏览器复制命令
      alert("复制成功");
    }
JS;

$this->registerJS($js,View::POS_HEAD);
$this->registerCss($css);
?>

<img src="<?= Url::to(['audit/code','id'=>$id])  ?>" />
<div class="wrapper1">
<p id="url"><?= $url ?></p>
<textarea id="input">这是幕后黑手</textarea>
<button onclick="copyText()">复制</button>
<div class="clear"></div>
</div>