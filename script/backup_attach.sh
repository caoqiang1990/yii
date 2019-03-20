#!/bin/bash

mypath='~/backup'                               #日志备份到该目录下，定义变量使用单引号
mylog='/var/www/yii/backend/web/uploads'
time=`date +%Y%m%d%H%M%S`                       #时间戳，执行命令使用``,esc下面的

tar zcvf ${mypath}/${time}.tar.gz ${mylog}       #备份附件到到/backup路径下
