<?php

use yii\web\View;

$this->title = '比稿管理操作手册';

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
        /*margin-bottom: 10px;*/
    }
CSS;

$this->registerCss($css);
?>
<ol>
    <li>
        比稿的创建
        <ol>
            <li>
                点击【比稿管理】->【创建比稿】
                <img src="/static/images/help/1.png" style="width:100%">
            </li>
            <li>
                填写【项目名称】->选择【起始时间】不选则默认为当前时间->选择【参与比稿供应商】参与比稿供应商可选两个或多个（输入关键字可带出候选供应商）
                <img src="/static/images/help/2.png" style="width:100%">
            </li>
            <li>
                填写【项目描述】->【发起者部门】由系统自动带出不可修改->选择【参与比稿人员】，参与比稿人员可选一个或多个->填写【供应商需提供的材料及要求】
                <img src="/static/images/help/3.png" style="width:100%">
            </li>
            <li>
                选择【是否通过邮件提供材料】
                A.选择“是”，则后续可以由系统发送邮件邀请参加比稿供应商提供比稿资料，【供应商邮箱】自动带出已经维护至系统的供应商邮箱，系统中未维护邮箱的，请按照“供应商名称:邮箱;供应商名称:邮箱;”的格式填写（注意格式中的标点为英文标点）
                <img src="/static/images/help/4.png" style="width:100%">
            </li>
            <li>
                B.选择“否”，则需要由比稿发起人自行知会【参与比稿供应商】提供比稿资料，后续再将线下比稿资料上传至其创建的比稿中
                1.5点击【新增按钮】比稿创建完成
            </li>
            <li>
                点击【比稿管理】->点击【我发起的项目】可查询到已经发起的比稿并对比稿进行“查看/更新/删除”操作
                <ol>
                    <li>
                        点击【查看】图标，可查看该比稿的各项信息
                        <img src="/static/images/help/5.png" style="width:100%">
                    </li>
                    <li>
                        点击【更新】按钮，可以对比稿信息进行更新，信息填写方式同创建比稿
                        <img src="/static/images/help/6.png" style="width:100%">
                    </li>
                    <li>
                        点击【删除】按钮，系统弹出提示是否确定删除比稿，点击“是”删除比稿，反之点击“取消”
                        <img src="/static/images/help/7.png" style="width:100%">
                    </li>
                </ol>
            </li>
        </ol>
    </li>
    <li>
        比稿开始与上传资料
        <ol>
            <li>
                选择“通过邮件提供材料”的比稿
                <ol>
                    <li>
                        点击【比稿管理】->【我发起的比稿】->【上传资料】，系统将发送邮件邀请供应商上传比稿资料
                        <img src="/static/images/help/8.png" style="width:100%">
                    </li>
                    <li>
                        参加比稿供应商的邮箱将收到如下邮件，点击链接后可通过拖拽初步选择要上传比稿资料->比稿资料最终确定后点击【上传】按钮->点击【提交】完成比稿资料上传
                        <img src="/static/images/help/9.png" style="width:100%">
                        <img src="/static/images/help/10.png" style="width:100%">
                        <img src="/static/images/help/11.png" style="width:100%">
                    </li>
                    <li>
                        点击【比稿管理】->【比稿记录】查看比稿记录，在比稿记录中点击【附件图标】可在浏览器跳出的新页面查看附件内容
                        <img src="/static/images/help/12.png" style="width:100%">
                    </li>
                </ol>
            </li>
            <li>
                选择“不通过邮件提供材料”的比稿
                <ol>
                    <li>
                        点击【比稿管理】->【我发起的比稿】->【上传资料】直接开始比稿
                        <img src="/static/images/help/13.png" style="width:100%">
                    </li>
                </ol>
            </li>

        </ol>
    </li>
    <li>
        比稿结束
        <ol>
            <li>
                选择“通过邮件上传资料”的比稿
                <ol>
                    <li>
                        点击【比稿管理】->【我发起的比稿】->【比稿结束】，比稿发起人可在弹出的界面中进一步完善比稿资料。
                        <img src="/static/images/help/14.png" style="width:100%">
                    </li>
                    <li>
                        拖拽初步选择比稿资料->确定比稿资料后点击【上传】
                        <img src="/static/images/help/15.png" style="width:100%">
                    </li>
                    <li>
                        填写【比稿结果】、【比稿说明】->点击【结束】
                        <img src="/static/images/help/16.png" style="width:100%">
                    </li>
                </ol>
            </li>
            <li>
                选择“不通过邮件上传资料”的比稿
                <ol>
                    <li>
                        线下比稿结束后点击点击【比稿管理】->【我发起的比稿】->【比稿结束】
                        <img src="/static/images/help/17.png" style="width:100%">
                    </li>
                    <li>
                        拖拽初步选择供应商线下提供的比稿资料->确定比稿资料后点击【上传】
                        <img src="/static/images/help/18.png" style="width:100%">
                    </li>
                    <li>
                        填写【比稿结果】、【比稿说明】->点击【结束】
                        <img src="/static/images/help/19.png" style="width:100%">
                    </li>
                </ol>
            </li>
            <li>
                比稿结束后可点击【比稿管理】->【比稿记录】查看比稿记录及结果
                <img src="/static/images/help/20.png" style="width:100%">
                <img src="/static/images/help/21.png" style="width:100%">
            </li>
        </ol>
    </li>
</ol>