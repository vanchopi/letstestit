<?php $request = app('Illuminate\Http\Request'); ?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li>
                <a href="<?php echo e(url('/')); ?>">
                    <i class="fa fa-wrench"></i>
                    <span class="title"><?php echo app('translator')->getFromJson('quickadmin.qa_dashboard'); ?></span>
                </a>
            </li>

            <li class="treeview" v-if="$can('user_management_access')">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span><?php echo app('translator')->getFromJson('quickadmin.user-management.title'); ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('permission_access')">
                        <router-link :to="{ name: 'permissions.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span><?php echo app('translator')->getFromJson('quickadmin.permissions.title'); ?></span>
                        </router-link>
                    </li>
                    <li v-if="$can('role_access')">
                        <router-link :to="{ name: 'roles.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span><?php echo app('translator')->getFromJson('quickadmin.roles.title'); ?></span>
                        </router-link>
                    </li>
                    <li v-if="$can('user_access')">
                        <router-link :to="{ name: 'users.index' }">
                            <i class="fa fa-user"></i>
                            <span><?php echo app('translator')->getFromJson('quickadmin.users.title'); ?></span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li v-if="$can('category_access')">
                <router-link :to="{ name: 'categories.index' }">
                    <i class="fa fa-gears"></i>
                    <span><?php echo app('translator')->getFromJson('quickadmin.categories.title'); ?></span>
                </router-link>
            </li>
            <li v-if="$can('test_access')">
                <router-link :to="{ name: 'tests.index' }">
                    <i class="fa fa-gears"></i>
                    <span><?php echo app('translator')->getFromJson('quickadmin.tests.title'); ?></span>
                </router-link>
            </li>

            <li>
                <router-link :to="{ name: 'auth.change_password' }">
                    <i class="fa fa-key"></i>
                    <span class="title"><?php echo app('translator')->getFromJson('quickadmin.qa_change_password'); ?></span>
                </router-link>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title"><?php echo app('translator')->getFromJson('quickadmin.qa_logout'); ?></span>
                </a>
            </li>
        </ul>
    </section>
</aside>
