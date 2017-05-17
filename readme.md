# Notadd Content

[![Build Status](https://travis-ci.org/notadd/content.svg?branch=master)](https://travis-ci.org/notadd/content)
![Packagist](https://img.shields.io/packagist/v/notadd/content.svg) 
![Downloads](https://img.shields.io/packagist/dt/notadd/content.svg)

Notadd Framework 的 CMS 模块。

## 主要的特性

* 分为 Article、Category、Page三个子模块
* 每一个模块中均包含有 Type、Template 两个子模块，对应为每个模块的类型、模板
* 每个模块实现有 Creator、Deleter、Editor、Finder 四类 API 实现

## 安装

安装前，请确保 **[Notadd](https://github.com/notadd/notadd)** 已经完成安装。

```bash
cd notadd/modules
git clone https://github.com/notadd/content.git
cd content
composer install --no-dev
```

## 文档

更多文档，请前往 **[Notadd 官方文档站点](https://docs.notadd.com)** 查阅！
