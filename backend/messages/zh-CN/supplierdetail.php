<?php

$fund_year1 = date('Y') - 3;
$fund_year2 = date('Y') - 2;
$fund_year3 = date('Y') - 1;

return [
    'name' => '我方对接人',
    'mobile' => '我方对接人电话',
    'reason' => '爱慕选择合作的原因',
    'created_at' => '创建时间',
    'updated_at' => '修改时间',
    'one_level_department' => '一级部门',
    'second_level_department' => '二级部门',
    'id' => '序号',
    'coop_fund1' => $fund_year1.'年合同金额（万元）',
    'coop_fund2' => $fund_year2.'年合同金额（万元）',
    'coop_fund3' => $fund_year3.'年合同金额（万元）',
    'trade_fund1' => $fund_year1.'年交易金额（万元）',
    'trade_fund2' => $fund_year2.'年交易金额（万元）',
    'trade_fund3' => $fund_year3.'年交易金额（万元）',
    'Create Supplier Detail' => '新增供应商详情',
    'Supplier Details' => '供应商详情',
    'Sid' => '供应商名称',
    'Update' => '更新',
    'Delete' => '删除',
    'Update Supplier Detail：' => '更新供应商详情：',
    'coop_date' => '合作时间',
    'level' => '供应商等级',
    'cate_id1' => '总类',
    'cate_id2' => '大类',
    'cate_id3' => '子类',
    'develop_department' => '开发部门',
  ];



?>