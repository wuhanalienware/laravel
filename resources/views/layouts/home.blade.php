<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- 引入页面描述和关键字模板 -->
    <title>@yield('title')</title>
    <meta name="description" content="云悦读专注于提供多元化的阅读体验，以阅读提升生活品质" />
    <meta name="keywords" content="云悦读,悦读,阅读,文字,历史,杂谈,散文,见闻,游记,人文,科技,杂碎,冷笑话,段子,语录" />
    @include('home.public.styles')
    @include('home.public.script')
</head>
<body id="wrap" class="home blog">
<!-- Nav -->
<!-- Moblie nav-->
<div id="body-container">
@include('home.public.navmenu')
    <!-- /.Moblie nav -->
    <section id="content-container" style="background:#f1f4f9; ">
    @include('home.public.header')
    <!-- Main Wrap -->
   @section('main-wrap')
            @include('home.public.aside')
       @show


        @include('home.public.footer')
    </section>
</div>

@include('home.public.signin')
@include('home.public.footerjs')
</body>
</html>
