<?php
//输出函数定义的位置
function func_dump($funcname) {
    try{
        if(is_array($funcname)) {
            $func = new ReflectionMethod($funcname[0], $funcname[1]);
            $funcname = $funcname[1];
        } else {
            $func = new ReflectionFunction($funcname);
        }
    }catch (ReflectionException $e) {
        echo $e->getMessage();
        return;
    }
    $start = $func->getStartLine();
    $end =  $func->getEndLine();
    $filename = $func->getFileName();
    echo "函数{$funcname}被定义在【{$filename}】文件中第{$start}行到{$end}行\n";
}
