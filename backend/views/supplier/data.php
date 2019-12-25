<?php

$this->title = '';
$this->params['breadcrumbs'][] = "统计";

?>


<table class="table table-bordered" >

    <tr style="font-weight: bold">
        <td>类别</td>
        <td>总数</td>
        <td>待评</td>
        <td>合格</td>
        <td>优秀</td>
        <td>战略</td>
        <td>不合格</td>
    </tr>
<?php  foreach ($data as $name => $info) { ?>

    <tr>
        <td><?=$name;?></td>
        <?php foreach ($info as $v) {?>
            <td><?=$v;?></td>
        <?php } ?>
    </tr>


<?php  } ?>


</table>
