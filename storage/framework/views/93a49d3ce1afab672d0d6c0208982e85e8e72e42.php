<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- 引入页面描述和关键字模板 -->
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta name="description" content="云悦读专注于提供多元化的阅读体验，以阅读提升生活品质" />
    <meta name="keywords" content="云悦读,悦读,阅读,文字,历史,杂谈,散文,见闻,游记,人文,科技,杂碎,冷笑话,段子,语录" />
    <?php echo $__env->make('home.public.styles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('home.public.script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body id="wrap" class="home blog">
<!-- Nav -->
<!-- Moblie nav-->
<div id="body-container">
<?php echo $__env->make('home.public.navmenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- /.Moblie nav -->
    <section id="content-container" style="background:#f1f4f9; ">
    <?php echo $__env->make('home.public.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- Main Wrap -->
   <?php $__env->startSection('main-wrap'); ?>
            <?php echo $__env->make('home.public.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
       <?php echo $__env->yieldSection(); ?>


        <?php echo $__env->make('home.public.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </section>
</div>

<?php echo $__env->make('home.public.signin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('home.public.footerjs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>
