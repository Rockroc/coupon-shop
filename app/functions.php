<?php


//计算分页开始位置
function get_offset($size = 10)
{
    $page  = app('request')->get('page') ?? 1;
    $limit = ($page - 1) * $size;
    return $limit;
}