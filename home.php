<?php
// 统计两个图库的图片数量
function countImages($filename) {
    if (!file_exists($filename)) {
        return 0;
    }
    
    $count = 0;
    try {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line) && filter_var($line, FILTER_VALIDATE_URL)) {
                $count++;
            }
        }
    } catch (Exception $e) {
        return 0;
    }
    
    return $count;
}

// 获取文件最后修改时间
function getFileUpdateTime($filename) {
    if (!file_exists($filename)) {
        return '未知';
    }
    
    $timestamp = filemtime($filename);
    return date('Y-m-d', $timestamp);
}

$acg_count = countImages('acg.txt');
$reality_count = countImages('reality.txt');
$total_count = $acg_count + $reality_count;

// 获取最新更新时间
$acg_time = getFileUpdateTime('acg.txt');
$reality_time = getFileUpdateTime('reality.txt');
$latest_time = max($acg_time, $reality_time);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="寂寞沙洲冷">
    <title>随机图片API - 二次元/三次元双图库</title>
    <link rel="shortcut icon" href="../favicon.ico">
    <meta name="keywords" content="图库,二次元图片,三次元图片,动漫图片API,图片API,随机图片API">
    <meta name="description" content="随机图片API - 收录二次元和三次元高质量图片，提供简单易用的API接口">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="main.css?ver=2.1">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="site-title">随机图片API</h1>
            <p class="site-subtitle">二次元/三次元双图库随机展示</p>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="api-info">
                <div class="stats-card">
                    <h2><i class="glyphicon glyphicon-stats"></i> 图库统计</h2>
                    <p>总图片数量: <span class="highlight"><?php echo $total_count; ?>+</span> 张</p>
                    <p>二次元图片: <span class="highlight"><?php echo $acg_count; ?>+</span> 张</p>
                    <p>三次元图片: <span class="highlight"><?php echo $reality_count; ?>+</span> 张</p>
                    <p>最后更新时间: <span class="highlight"><?php echo $latest_time; ?></span></p>
                </div>

                <div class="usage-card">
                    <h2><i class="glyphicon glyphicon-cog"></i> API使用说明</h2>
                    <div class="note-section">
                        <p><i class="glyphicon glyphicon-info-sign"></i> 支持二次元和三次元两种图片分类</p>
                        <p><i class="glyphicon glyphicon-random"></i> 使用 category 参数切换分类：acg(二次元) 或 reality(三次元)</p>
                        <p><i class="glyphicon glyphicon-cloud"></i> 图片均采用CDN加速，高速访问</p>
                        <p><i class="glyphicon glyphicon-picture"></i> 图片未压缩，保留原画质</p>
                    </div>
                </div>

                <div class="endpoints-card">
                    <h2><i class="glyphicon glyphicon-link"></i> API调用方式</h2>
                    
                    <div class="endpoint">
                        <h3>1. 默认调用（重定向到图片）</h3>
                        <h4>二次元图片：</h4>
                        <pre><code>GET <?php echo $_SERVER['HTTP_HOST']; ?>/?category=acg</code></pre>
                        <h4>三次元图片：</h4>
                        <pre><code>GET <?php echo $_SERVER['HTTP_HOST']; ?>/?category=reality</code></pre>
                    </div>
                    
                    <div class="endpoint">
                        <h3>2. JSON格式调用</h3>
                        <h4>二次元图片：</h4>
                        <pre><code>GET <?php echo $_SERVER['HTTP_HOST']; ?>/?category=acg&type=json</code></pre>
                        <h4>三次元图片：</h4>
                        <pre><code>GET <?php echo $_SERVER['HTTP_HOST']; ?>/?category=reality&type=json</code></pre>
                        <p>返回示例：</p>
                        <pre class="json-example"><code>{
    "pic": "https://example.com/image.jpg",
    "category": "acg",
    "category_name": "二次元",
    "count": 650
}</code></pre>
                    </div>
                    
                    <div class="endpoint">
                        <h3>3. 直接输出图片</h3>
                        <h4>二次元图片：</h4>
                        <pre><code>GET <?php echo $_SERVER['HTTP_HOST']; ?>/?category=acg&type=img</code></pre>
                        <h4>三次元图片：</h4>
                        <pre><code>GET <?php echo $_SERVER['HTTP_HOST']; ?>/?category=reality&type=img</code></pre>
                        <p>直接返回图片二进制数据</p>
                    </div>
                    
                    <div class="endpoint">
                        <h3>4. 访问首页</h3>
                        <pre><code>GET <?php echo $_SERVER['HTTP_HOST']; ?>/?show=1</code></pre>
                        <p>显示本帮助页面</p>
                    </div>
                </div>
            </div>
            
            <div class="quick-test">
                <h2><i class="glyphicon glyphicon-flash"></i> 快速测试</h2>
                <div class="test-buttons">
                    <a href="?category=acg" target="_blank" class="btn btn-primary">
                        <i class="glyphicon glyphicon-picture"></i> 随机二次元图片
                    </a>
                    <a href="?category=reality" target="_blank" class="btn btn-success">
                        <i class="glyphicon glyphicon-camera"></i> 随机三次元图片
                    </a>
                    <a href="?category=acg&type=json" target="_blank" class="btn btn-info">
                        <i class="glyphicon glyphicon-list-alt"></i> 二次元JSON数据
                    </a>
                    <a href="?category=reality&type=json" target="_blank" class="btn btn-warning">
                        <i class="glyphicon glyphicon-list-alt"></i> 三次元JSON数据
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>Copyright &copy; 寂寞沙洲冷 2018-2026</p>
            <p>随机图片API - 二次元/三次元双图库系统</p>
            <p>QQ/WX：1638276310</p>
            <p>
                <!-- 工信部备案号 -->
                <a href="https://beian.miit.gov.cn/" target="_blank" style="color: #dfe6e9; text-decoration: none; margin-right: 20px;">
                    <i class="glyphicon glyphicon-certificate"></i> 晋ICP备2025067826号-1
                </a>
                
                <!-- 公安备案号及图标 -->
                <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=440000000000" target="_blank" style="color: #dfe6e9; text-decoration: none; display: inline-flex; align-items: center;">
                    <img src="https://img.alicdn.com/tfs/TB1..50QpXXXXX7XpXXXXXXXXXX-40-40.png" style="height: 16px; margin-right: 5px; vertical-align: middle;">
                    晋公网安备 xxxxxxxxxxxx号
                </a>
            </p>
        </div>
    </footer>
</body>
</html>