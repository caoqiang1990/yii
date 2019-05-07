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
        /*margin-bottom: 10px;*/
    }
    .col-md-6{
    height: 250px;
    border:1px solid #fff;
    }
    #left_1{
       /* background-color:#1b6d85;*/
    }
    .container-fluid{
        padding-top:20px
    }
CSS;
$js = <<<JS
        // 基于准备好的dom，初始化echarts实例
        var myChart_1 = echarts.init(document.getElementById('middle_1'));

        // 指定图表的配置项和数据

        option_1 = {
            title: {
                text: '供应商管理一级部门',
                textStyle:{fontSize:15},
                x:'center',
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                min:0,
                max:300,
            },
            yAxis: {
                type: 'category',
                data: [$nameStr]
            },
            series: [
                {
                    type: 'bar',
                    data: [$valueStr]
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart_1.setOption(option_1);
        
        
        var myChart_2 = echarts.init(document.getElementById('right_1'));

        var colors = ['#5793f3', '#d14a61', '#675bba'];

        option_2 = {
            color: colors,
        
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross'
                }
            },
            grid: {
                right: '20%'
            },
            toolbox: {
                feature: {
                    dataView: {show: true, readOnly: false},
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            legend: {
                data:['蒸发量','降水量','平均温度']
            },
            xAxis: [
                {
                    type: 'category',
                    axisTick: {
                        alignWithLabel: true
                    },
                    data: [{$yearStr}]
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    name: '供应商数量',
                    min: 0,
                    max: 2000,
                    position: 'right',
                    axisLine: {
                        lineStyle: {
                            color: colors[0]
                        }
                    },
                    axisLabel: {
                        formatter: '{value}'
                    }
                },
                {
                    type: 'value',
                    name: '交易金额(千万元)',
                    min: 0,
                    max: 100,
                    position: 'left',
                    axisLine: {
                        lineStyle: {
                            color: colors[2]
                        }
                    },
                    axisLabel: {
                        formatter: '{value}'
                    }
                }
            ],
            series: [
                {
                    name:'供应商数量',
                    type:'bar',
                    data:[{$totalSupplierCount}]
                },
                {
                    name:'交易金额',
                    type:'line',
                    yAxisIndex: 1,
                    data:[{$totalTradeFund}]
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart_2.setOption(option_2);
        
        
        myChart_3 = echarts.init(document.getElementById('left_2'));
        option_3 = {
            title: {
                text: '供应商合作类型',
                textStyle:{fontSize:15},
                x:'center',
            },
            color: ['#3398DB'],
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    data : [{$typeNameStr}],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    type:'bar',
                    barWidth: '60%',
                    data:[{$typeValueStr}]
                }
            ]
        };
        myChart_3.setOption(option_3);
        
        myChart_4 = echarts.init(document.getElementById('middle_2'));
        
        option_4 = {
            title : {
                text: '供应商企业性质',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: [{$natureNameStr}]
            },
            series : [
                {
                    name: '企业性质',
                    type: 'pie',
                    radius : ['40%','70%'],
                    center: ['50%', '60%'],
                    data:{$natureValueStr},
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        myChart_4.setOption(option_4);
        
          
        
        myChart_5 = echarts.init(document.getElementById('left_3'));
        option_5 = {
            color: ['#3398DB'],
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    data : [{$levelNameStr}],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'数量',
                    type:'bar',
                    barWidth: '60%',
                    data:[{$levelValueStr}]
                }
            ]
        };
        myChart_5.setOption(option_5);
        
        myChart_6 = echarts.init(document.getElementById('middle_3'));
        option_6 = {
            title : {
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                type: 'scroll',
                orient: 'vertical',
                right: 10,
                top: 20,
                bottom: 20,
                data: [{$categoryNameStr}],
        
                selected: {$categorySelectedStr}
            },
            series : [
                {
                    name: '一级大类',
                    type: 'pie',
                    radius : '55%',
                    center: ['40%', '50%'],
                    data: {$categoryValueStr},
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        
        myChart_6.setOption(option_6);

JS;

$this->registerCss($css);
$this->registerJsFile('js/echarts.min.js');
$this->registerJs($js);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row" style="background-color:#1b6d85;padding: 10px;margin-bottom: 1px;color:white"><span style="font-size: 20px;font-weight: bolder;">集团供应商 ：</span><span style="font-size:20px;font-weight: bolder"><?= $totalCount; ?></span> <span style="font-size: 20px;font-weight: bolder">个</span></div>
        </div>
<!--        <div class="col-md-6" id="left_1">-->
<!--            <span style="float:left;font-size: 20px;font-weight: bolder">集团供应商</span>-->
<!--            <span style="position:absolute;top:45%;left:42%;font-size:30px;font-weight: bolder">--><?//= $totalCount; ?><!--</span>-->
<!--            <span style="position: absolute;float: right;bottom: 10px;right:10px;font-size: 20px;font-weight: bolder">个</span>-->
<!--        </div>-->
        <div class="col-md-6" id="right_1">3</div>
        <div class="col-md-6" id="middle_1">2</div>
    </div>
    <div class="row">
        <div class="col-md-6" id="left_2">3</div>
        <div class="col-md-6" id="middle_2">3</div>
    </div>
    <div class="row">
        <div class="col-md-6" id="left_3"></div>
        <div class="col-md-6" id="middle_3">3</div>
    </div>
</div>



