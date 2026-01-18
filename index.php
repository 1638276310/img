<?php
/**
 * 随机图片API - 支持二次元/三次元双图库
 * 作者: 寂寞沙洲冷
 * 最后更新: 2025-11-8
 * 修改说明: 优化JSON接口空文件处理，返回标准JSON而非错误文本
 */

// 设置默认响应头
header("Content-Type: text/html; charset=UTF-8");

// 获取请求参数
$type = isset($_GET['type']) ? $_GET['type'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'acg'; // 默认二次元
$show = isset($_GET['show']) ? $_GET['show'] : false;

// 根据分类选择对应的图片文件
$filename = "";
if ($category === 'acg') {
    $filename = "acg.txt";
} elseif ($category === 'reality') {
    $filename = "reality.txt";
} else {
    // 默认使用二次元
    $category = 'acg';
    $filename = "acg.txt";
}

// 如果只是显示页面（没有API请求）
if ($show && empty($type)) {
    include_once('home.php');
    exit();
}

// ============== 核心逻辑：读取与处理图片链接 ==============
$pics = [];
$fileExists = file_exists($filename);

if ($fileExists) {
    // 文件存在，尝试读取内容
    try {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            // 验证是否为有效的URL格式
            if (!empty($line) && filter_var($line, FILTER_VALIDATE_URL)) {
                $pics[] = $line;
            }
        }
    } catch (Exception $e) {
        // 文件读取异常
        if ($type === 'json') {
            header('Content-Type: application/json; charset=UTF-8');
            http_response_code(500);
            echo json_encode([
                'error' => '读取文件时发生异常',
                'pic' => '',
                'category' => $category,
                'category_name' => $category === 'acg' ? '二次元' : '三次元',
                'count' => 0
            ], JSON_UNESCAPED_SLASHES);
        } else {
            http_response_code(500);
            die('读取文件时发生错误');
        }
        exit();
    }
}

// 计算图片总数
$picCount = count($pics);

// ============== 根据请求类型返回响应 ==============
switch ($type) {
    // ---------- JSON格式返回 ----------
    case 'json':
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: public, max-age=300'); // 缓存5分钟
        
        // 构建标准响应
        $response = [
            'pic' => $picCount > 0 ? $pics[array_rand($pics)] : '', // 关键修改：空文件时返回空字符串
            'category' => $category,
            'category_name' => $category === 'acg' ? '二次元' : '三次元',
            'count' => $picCount // 正确反映实际图片数量
        ];
        
        // 可选：如果文件不存在，可以在JSON中添加提示信息
        if (!$fileExists) {
            $response['notice'] = '指定的图库文件不存在';
        }
        
        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        break;
    
    // ---------- 直接输出图片 ----------
    case 'img':
        // 如果没有可用的图片，则无法输出
        if ($picCount === 0) {
            http_response_code(500);
            // 如果是空文件，给出相应提示
            $message = $fileExists ? '图库文件为空，没有有效的图片链接' : '指定的图库文件不存在';
            die($message);
        }
        
        // 设置缓存和图片头
        header("Cache-Control: public, max-age=86400"); // 缓存1天
        header("Content-Type: image/jpeg");
        
        // 随机选择一张图片
        $pic = $pics[array_rand($pics)];
        
        // 尝试获取远程图片
        $context = stream_context_create([
            'http' => [
                'timeout' => 10, // 10秒超时
                'user_agent' => 'RandomImageAPI/2.0'
            ]
        ]);
        
        $img = @file_get_contents($pic, false, $context);
        if ($img === FALSE) {
            http_response_code(500);
            die('无法获取远程图片');
        }
        
        echo $img;
        break;
    
    // ---------- 默认：重定向到图片 ----------
    default:
        // 如果没有可用的图片，则无法重定向
        if ($picCount === 0) {
            http_response_code(500);
            // 如果是空文件，给出相应提示
            $message = $fileExists ? '图库文件为空，没有有效的图片链接' : '指定的图库文件不存在';
            die($message);
        }
        
        // 正常情况：重定向到随机图片
        $pic = $pics[array_rand($pics)];
        header("Location: $pic", true, 302);
        break;
}