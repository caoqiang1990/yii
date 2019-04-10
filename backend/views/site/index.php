<?php
use yii\web\View;

$this->title = '欢迎登录爱慕供应商系统';

$css = <<<CSS
  ol li{
    font-size: 18px;
    margin-bottom: 20px
  }
  h4{
    font-weight: bold;
    margin-bottom: 20px
  }
  .content{
    padding:0px 15px 15px 15px;
  }
  ul li {
    margin-bottom: 10px;
  }
CSS;

$this->registerCss($css);
?>
<img src="/static/images/paper.jpg" style="width:100%">
