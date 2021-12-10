<form action="<?php echo e(asset('/admin/search')); ?>" method="GET" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="term" class="form-control" placeholder="
            <?php echo app('translator')->getFromJson('admin.search_apps'); ?>
            ">
        <span class="input-group-btn">
            <button type="submit" id="search-btn" class="btn btn-flat">
                <i class="fas fa-search"></i>
            </button>
        </span>
    </div>
</form>

<li class="header"><?php echo app('translator')->getFromJson('admin.administration'); ?></li>

<li class="treeview<?php echo e(Request::is('admin/apps*', 'admin', 'admin/search')  ? ' active' : ''); ?>">
    <a href="#">
        <i class="fas fa-mobile-alt "></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.apps'); ?>
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo e(Request::is('admin/apps', 'admin', 'admin/apps/*/edit', 'admin/search') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/apps')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.apps'); ?>
                </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/apps/create') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/apps/create')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.create_app'); ?>
                </span>
            </a>
        </li>
    </ul>
</li>

<li class="treeview<?php echo e(Request::is('admin/categories*') ? ' active' : ''); ?>">
    <a href="#">
        <i class="fas fa-bookmark "></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.categories'); ?>
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo e(Request::is('admin/categories', 'admin/categories/*/edit') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/categories')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.categories'); ?>
                </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/categories/create') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/categories/create')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.create_category'); ?>
                </span>
            </a>
        </li>
    </ul>
</li>

<li class="treeview<?php echo e(Request::is('admin/platforms*')  ? ' active' : ''); ?>">
    <a href="#">
        <i class="fab fa-windows "></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.platforms'); ?>
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo e(Request::is('admin/platforms', 'admin/platforms/*/edit') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/platforms')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.platforms'); ?>
                </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/platforms/create') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/platforms/create')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.create_platform'); ?>
                </span>
            </a>
        </li>
    </ul>
</li>

<li class="treeview<?php echo e(Request::is('admin/pages*')  ? ' active' : ''); ?>">
    <a href="#">
        <i class="fas fa-file "></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.pages'); ?>
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo e(Request::is('admin/pages', 'admin/pages/*/edit') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/pages')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.pages'); ?>
                </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/pages/create') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/pages/create')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.create_page'); ?>
                </span>
            </a>
        </li>
    </ul>
</li>

<li class="treeview<?php echo e(Request::is('admin/sliders*')  ? ' active' : ''); ?>">
    <a href="#">
        <i class="fas fa-sliders-h"></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.sliders'); ?>
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo e(Request::is('admin/sliders', 'admin/sliders/*/edit') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/sliders')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.sliders'); ?>
                </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/sliders/create') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/sliders/create')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.create_slider'); ?>
                </span>
            </a>
        </li>
    </ul>
</li>


<li class="treeview<?php echo e(Request::is('admin/topic*', 'admin/topics*')  ? ' active' : ''); ?>">
    <a href="#">
        <i class="fas fa-star"></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.topics'); ?>
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo e(Request::is('admin/topics', 'admin/topics/*/edit', 'admin/topic/*') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/topics')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.topics'); ?>
                </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/topics/create') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/topics/create')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.create_topic'); ?>
                </span>
            </a>
        </li>
    </ul>
</li>

<li class="treeview<?php echo e(Request::is('admin/news*')  ? ' active' : ''); ?>">
    <a href="#">
        <i class="fas fa-font"></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.news'); ?>
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo e(Request::is('admin/news', 'admin/news/*/edit') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/news')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.news'); ?>
                </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/news/create') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/news/create')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.create_news'); ?>
                </span>
            </a>
        </li>
    </ul>
</li>

<li class="treeview<?php echo e(Request::is('admin/scraper*', 'admin/scraper_categories')  ? ' active' : ''); ?>">
    <a href="#">
        <i class="fas fa-cube"></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.content_scraper'); ?>
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo e(Request::is('admin/scraper/*') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/scraper')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.content_scraper'); ?>
                </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/scraper_categories') ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/scraper_categories')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
                    <?php echo app('translator')->getFromJson('admin.category_settings'); ?>
                </span>
            </a>
        </li>
    </ul>
</li>

<li class="treeview<?php echo e(Request::is('admin/settings*', 'admin/permalinks*', 'admin/account_settings*', 'admin/translations*')  ? ' active' : ''); ?>">
    <a href="#">
        <i class="fas fa-cog"></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.settings_general'); ?>
        </span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo e(Request::is('admin/settings*')  ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/settings')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.settings'); ?>
        </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/permalinks*')  ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/permalinks')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.permalinks'); ?>
        </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/translations*')  ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/translations')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.translations'); ?>
        </span>
            </a>
        </li>
        <li class="<?php echo e(Request::is('admin/account_settings*')  ? 'active' : ''); ?>">
            <a href="<?php echo e(asset('/admin/account_settings')); ?>">
                <i class="fas fa-angle-right"></i>
                <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.account_settings'); ?>
        </span>
            </a>
        </li>
    </ul>
</li>

<li class="<?php echo e(Request::is('admin/ads*')  ? 'active' : ''); ?>">
    <a href="<?php echo e(asset('/admin/ads')); ?>">
        <i class="fas fa-flag "></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.ads'); ?>
        </span>
    </a>
</li>

<li class="<?php echo e(Request::is('admin/comments*')  ? 'active' : ''); ?>">
    <a href="<?php echo e(asset('/admin/comments')); ?>">
        <i class="fas fa-comments"></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.comments'); ?>
        </span>
        <?php if($pending_comments >= 1): ?>
        <span class="pull-right-container">
            <small class="label pull-right bg-orange">
                <?php echo e($pending_comments); ?></small>
        </span>
        <?php endif; ?>
    </a>
</li>

<li class="<?php echo e(Request::is('admin/submissions*')  ? 'active' : ''); ?>">
    <a href="<?php echo e(asset('/admin/submissions')); ?>">
        <i class="fas fa-file-import"></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.submissions'); ?>
        </span>
        <?php if($pending_submissions >= 1): ?>
        <span class="pull-right-container">
            <small class="label pull-right bg-olive">
                <?php echo e($pending_submissions); ?></small>
        </span>
        <?php endif; ?>
    </a>
</li>

<li class="">
    <a href="<?php echo e(asset('/admin/settings/clear_cache')); ?>" class="clear-cache" id="cache-info"
        data-cache-clear="<?php echo app('translator')->getFromJson('admin.cache_clear_message'); ?>" data-yes="<?php echo app('translator')->getFromJson('admin.yes'); ?>"
        data-cancel="<?php echo app('translator')->getFromJson('admin.cancel'); ?>">
        <i class="fas fa-server"></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.system_cache'); ?>
        </span>
        <?php if($total_cached >= 1): ?>
        <span class="pull-right-container">
            <small class="label pull-right bg-purple"><?php echo e($total_cached); ?></small>
        </span>
        <?php endif; ?>
    </a>
</li>

<li class="">
    <a href="https://codecanyon.net/item/app-portal/25416622/support" target="blank">
        <i class="fas fa-paper-plane"></i>
        <span class="ml-5">
            <?php echo app('translator')->getFromJson('admin.suggest_feature'); ?>
        </span>
    </a>
</li>

<li>
    <a href="https://foxart.co/documentation/app-portal/" target="_blank">
        <i class="fa fa-book"></i>
        <span>
            <?php echo app('translator')->getFromJson('admin.documentation'); ?>
        </span>
    </a>
</li>

<li>
    <a href="javascript:void(0);" class="v_control" id="v_control" onclick="executeExample('dynamicQueue')"
        data-version-control="<?php echo app('translator')->getFromJson('admin.version_control'); ?>" data-version-info="<?php echo app('translator')->getFromJson('admin.version_check_info'); ?>"
        data-latest-version="<?php echo app('translator')->getFromJson('admin.check_latest_version'); ?>"
        data-version-control-fail="<?php echo app('translator')->getFromJson('admin.version_control_fail'); ?>">
        <i class="fa fa-code-branch"></i>
        <span>
            App Portal 1.3
        </span>
    </a>
</li><?php /**PATH /home/cariazlj/prod.foxart.co/lapp/resources/views/vendor/adminlte/partials/menu-item.blade.php ENDPATH**/ ?>