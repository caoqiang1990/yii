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
<div class="container-fluid">
<div class="row">
<br />
</div>
  <div class="row">
      <h4>供应商管理系统信息完善时间要求：</h4>
      <ol>
        <li>2019年1月15日前，将2018年及之前未录入系统的合作供应商补录完整（路径：“供应商名录变更->新增供应商”）。</li>
        <li>2019年1月20日前，将2018年合作信息补录完整（路径：“供应商名录变更->变更合作信息”下的“2018年合同金额”和“2018年交易金额”）。</li>
        <li>2019年2月1日前，完成2018年供应商等级评价并在系统中更新完毕（路径：“供应商名录变更->变更合作信息”下的“供应商等级”）。</li>
      </ol>
  </div>
  <div class="row">
    <div class="col-xs-12">
    <h4>使用指南：</h4>
    <ol>
      <li>
        共享范围释义：
        <ul>
          <li>供应商分为“集团共享”供应商和“部门共享”供应商。</li>
          <li>新增供应商时系统默认为“集团共享”，如为保密供应商（如特殊的原材料供应商），请在“供应商名录变更->变更基本信息”或“供应商名录变更->审核基本信息”处调整为“部门共享”。</li>
          <li>“供应商名录查询->集团供应商”中不显示其他部门的“部门共享”供应商。</li>
        </ul>
      </li>
      <li>
        <p>个人信息修改：</p>
        <img src="/static/images/intro/1.png">
      </li>
      <li>
          <p>供应商名录查询：</p>
          <img src="/static/images/intro/2.png" style="width:100%">
      </li>
      <li>
          <p>供应商名录变更->新增供应商</p>
          <img src="/static/images/intro/3.png" style="width:100%">
          <img src="/static/images/intro/4.png" style="width:100%">
      </li>
      <li>
          <p>供应商名录变更->变更基本信息</p>
          <img src="/static/images/intro/5.png" style="width:100%">
      </li>
      <li>
          <p>供应商名录变更->审核基本信息</p>
          <img src="/static/images/intro/6.png" style="width:100%">
      </li>
      <li>
          <p>供应商名录变更->变更合作信息</p>
          <img src="/static/images/intro/7.png" style="width:100%">
      </li>
      <li><p>技术支持：大数据信息中心010-84776011</p></li>
    </ol>
  </div>
  </div>
</div>