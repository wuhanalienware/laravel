<?php $__env->startSection('title','博客系统'); ?>


<?php $__env->startSection('main-wrap'); ?>
    <!-- Main Wrap -->
    <div id="main-wrap">
        <div id="sitenews-wrap" class="container"></div>
        <!-- Header Banner -->
        <!-- /.Header Banner -->
        <!-- CMS Layout -->
        <div class="container two-col-container cms-with-sidebar">
            <div id="main-wrap-left">
                <!-- Stickys -->
                <!-- /.Stickys -->

                <?php $__currentLoopData = $cate_arts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <section class="catlist-8 catlist clr">
                        <div class="catlist-container clr">
                            <h2 class="home-heading clr"><span class="heading-text"> <?php echo e($v->cate_name); ?> </span> <a
                                    href="lists.html?prose">+ 更多</a></h2>
                            <?php if(!empty($v->article)): ?>
                                <?php $__currentLoopData = $v->article; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($n->art_status == 1): ?>
                                        <span class="col-left catlist-style2">

                                              <article class="home-blog-entry clr">
                                               <a href="<?php echo e(url('/detail/'.$n->art_id)); ?>" title="<?php echo e($n->art_title); ?>"
                                                  class="fancyimg home-blog-entry-thumb">
                                                <div class="thumb-img">
                                                 <img src="<?php echo e($n->art_thumb); ?>" alt="<?php echo e($n->art_title); ?>"/>
                                                 <span><i class="fa fa-pencil"></i></span>
                                                </div> </a>
                                               <h3><a href="<?php echo e(url('/detail/'.$n->art_id)); ?>" title="<?php echo e($n->art_title); ?>"><?php echo e($n->art_title); ?></a></h3>
                                               <div class="postlist-meta">
                                                <span class="postlist-meta-time"><?php echo e(date('Y-m-d H:i:s',$v->art_time)); ?></span>
                                                <span class="delim"></span>
                                                <span class="postlist-meta-views">4&nbsp;℃</span>
                                                <span class="delim"></span>
                                                <span class="postlist-meta-comments"><i class="fa fa-comments"></i>&nbsp;<a
                                                        href="https://www.lmonkey.com/5151.html#comments">0</a></span>
                                                <div class="postlist-meta-like like-btn" style="float:right;" pid="5151" title="点击喜欢">
                                                 <i class="fa fa-heart"></i>&nbsp;
                                                 <span>0</span>&nbsp;
                                                </div>
                                                <div class="postlist-meta-collect collect collect-no" uid="1" artid="<?php echo e($n->art_id); ?>"
                                                     style="float:right;cursor:default;" title="必须登录才能收藏">
                                                 <i class="fa fa-star"></i>&nbsp;
                                                 <span><?php echo e($n->art_collect); ?></span>&nbsp;
                                                </div>
                                               </div>
                                               <p> <?php echo e($n->art_description); ?><a rel="nofollow" class="more-link" style="text-decoration:none;" href="<?php echo e(url('/detail/'.$n->art_id)); ?>"></a></p>
                                              </article> </span>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <span class="col-right catlist-style2">
         <?php if(!empty($v->article)): ?>
           <?php $__currentLoopData = $v->article; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($n->art_status == 0 && $m <=5): ?>
                  <article class="clr col-small">
                   <a href="<?php echo e(url('detail/'.$n->art_id)); ?>" title="<?php echo e($n->art_title); ?>" class="fancyimg home-blog-entry-thumb">
                    <div class="thumb-img">
                     <img src="<?php echo e($n->art_thumb); ?>" alt="<?php echo e($n->art_title); ?>"/>
                     <span><i class="fa fa-pencil"></i></span>
                    </div> </a>
                   <h3><a href="<?php echo e(url('detail/'.$n->art_id)); ?>" title="<?php echo e($n->art_title); ?>"><?php echo e($n->art_title); ?></a></h3>
                   <p> <?php echo e($n->art_description); ?><a rel="nofollow" class="more-link" style="text-decoration:none;"
                                                   href="<?php echo e(url('detail/'.$n->art_id)); ?>"></a> </p>
                  </article>

              <?php endif; ?>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
       </span>
                        </div>
                    </section>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- pagination -->
                <div class="clear">
                </div>
                <div class="pagination">
                </div>
                <!-- /.pagination -->
            </div>
            <script type="text/javascript">
                $('.site_loading').animate({'width': '55%'}, 50);  //第二个节点
            </script>
            
            ##parent-placeholder-4ea6d5a242c9a52f7a4c8c85c74f07675d76243d##
            
        </div>
        <div class="clear">
        </div>
        <!-- Blocks Layout -->
    </div>
    <!--/.Main Wrap -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>