# 🖼️ 随机图片API - 二次元/三次元双图库系统

一个简洁高效的随机图片API系统，支持二次元（动漫）和三次元（现实）双图库分类，提供多种调用方式。

![GitHub](https://img.shields.io/badge/PHP-7.0%2B-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Version](https://img.shields.io/badge/Version-2.1-orange)

## ✨ 特性亮点

- 🎯 **双图库分类**：二次元（ACG）和三次元（Reality）图片分离管理
- 📊 **实时统计**：自动统计图片数量，显示最后更新时间
- 🔧 **多格式支持**：支持重定向、JSON格式、直接图片输出三种调用方式
- ⚡ **CDN加速**：图片链接均使用CDN，确保高速访问
- 🎨 **响应式设计**：适配各种设备屏幕，美观实用
- 📱 **简洁API**：简单易用的API接口，一行代码即可调用

## 🗂️ 项目结构
### random-image-api/
- index.php # 主API入口文件
- home.php # 首页展示文件
- main.css # 样式文件
- acg.txt # 二次元图库（URL列表）
- reality.txt # 三次元图库（URL列表）
- favicon.ico # 


## 🚀 快速开始

### 环境要求
- PHP 7.0 或更高版本
- Web服务器（Apache/Nginx）
- 支持HTTPS（推荐）

### 部署步骤

1. **克隆或下载项目**
   ```bash
   git clone https://github.com/yourusername/random-image-api.git
   ```

上传到服务器

将项目文件上传到你的Web服务器目录（如 /var/www/html/ 或 public_html）

### 配置图库

编辑 acg.txt 文件，每行添加一个二次元图片URL

编辑 reality.txt 文件，每行添加一个三次元图片URL

确保图片URL格式正确，支持 https://

### 访问测试

访问 你的域名/?show=1查看首页  

访问 你的域名/?category=acg 测试随机二次元图片

访问 你的域名/?category=reality 测试随机三次元图片


### 📖 API使用文档
#### 基础参数
| 参数名 | 必填 | 默认值 | 说明 |
|--------|------|--------|------|
| category | 否 | acg | 图片分类：acg(二次元) 或 reality(三次元) |
| type | 否 | 空 | 返回类型：json、img 或空（重定向） |
| show | 否 | 空 | 值为1时显示首页界面 |

### API调用方式

#### 1. 默认调用（302重定向）
直接访问域名重定向到随机图片：

```http
GET /?category=acg
GET /?category=reality
```

### 2. JSON格式调用  
返回JSON格式的图片信息：
```http
GET /?category=acg&type=json   
GET /?category=reality&type=json   
```
返回示例：
```json
json
{
    "pic": "https://cdn.example.com/image.jpg",
    "category": "acg",
    "category_name": "二次元",
    "count": 1234
}
```
### 3. 直接输出图片
直接返回图片二进制数据：

```http  
GET /?category=acg&type=img  
GET /?category=reality&type=img  
```
### 4. 访问首页
显示统计信息和API文档：

```http
GET /?show=1
```
🎨 界面展示

响应式设计
桌面端：三栏布局，完整展示所有功能

平板端：两栏布局，优化显示

手机端：单栏布局，完美适配小屏幕

🔧 高级配置
自定义样式
编辑 main.css 文件可自定义界面样式：
```css
css
/* 修改主题色 */
.site-title {
    color: #您的颜色; /* 修改标题颜色 */
}

/* 修改卡片背景 */
.stats-card, .usage-card {
    background: #您的背景色; /* 修改卡片背景 */
}
```

扩展图库
添加新图片：直接在 acg.txt 或 reality.txt 中添加新的图片URL

格式要求：每行一个URL，必须是完整的HTTP/HTTPS链接

图片验证：系统会自动过滤无效的URL链接

性能优化建议
启用缓存：确保服务器已启用OPcache

CDN配置：推荐使用Cloudflare等CDN服务

图片压缩：建议源图片进行适当压缩

📊 统计功能
系统自动统计功能：

✅ 实时统计各图库图片数量

✅ 显示最后更新时间

✅ 总图片数量汇总

✅ 有效URL验证

🔒 安全说明
所有图片链接经过URL验证过滤

支持HTTPS协议，确保传输安全

文件读取异常处理，防止信息泄露

适当的HTTP响应码设置

📝 更新日志
v2.1 (2025-11-08)
✅ 优化JSON接口空文件处理

✅ 修复文件不存在时的错误处理

✅ 改进代码结构和注释

✅ 添加更详细的错误提示

v2.0 (2025-10-15)
✅ 重构项目结构，分离显示和API逻辑

✅ 新增JSON格式接口

✅ 添加图片直出功能

✅ 优化响应式设计

v1.0 (2024-09-01)
✅ 基础双图库系统

✅ 随机图片API

✅ 基础统计功能

✅ 响应式界面

🤝 贡献指南
欢迎提交Issue和Pull Request！

Fork 本仓库

创建您的特性分支 (git checkout -b feature/AmazingFeature)

提交您的更改 (git commit -m 'Add some AmazingFeature')

推送到分支 (git push origin feature/AmazingFeature)

开启一个Pull Request

📄 许可证
本项目采用 MIT 许可证 - 查看 LICENSE 文件了解详情。

📞 联系方式  
作者：寂寞沙洲冷

QQ/微信：1638276310



🙏 致谢
感谢所有为图库贡献图片的创作者们！

⭐ 如果这个项目对您有帮助，请给个Star支持一下！ ⭐

提示：本项目仅供学习和交流使用，请遵守相关法律法规，尊重图片版权。