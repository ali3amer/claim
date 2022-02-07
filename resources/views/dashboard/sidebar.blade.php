<div class="sidebar">
    <div class="logo-area text-center">نظام إحصاء المطالبات</div>
    <ul class="links-area list-unstyled">
        @if(Auth::user()->power == 'manger' || Auth::user()->power == 'dataEntry')
            <li>
                <router-link to="/clients">الاستمارات</router-link>
            </li>
        @endif

        @if(Auth::user()->power == 'city' || Auth::user()->power == 'manger' || Auth::user()->power == 'developer')
            <li>
                <router-link to="/reports">التقارير</router-link>
            </li>
        @endif

        @if(Auth::user()->power == 'manger')

            <li><a class="toggle-submenu" href="#">الاعدادات<i class="fa fa-angle-left"></i></a>
                <ul class="child-links list-unstyled">
                    <li>
                        <router-link to="/users">المستخدمين</router-link>
                    </li>

                    @if(Auth::user()->power == 'developer')
                    <li>
                        <router-link to="/states" style="display: none">الولايات</router-link>
                    </li>
                    @endif
                    <li>
                        <router-link to="/cities">المحليات</router-link>
                    </li>

                    <li>
                        <router-link to="/units">الوحدات الاداريه</router-link>
                    </li>

                    <li>
                        <router-link to="/categories">تصنيفات المراكز</router-link>
                    </li>

                    <li>
                        <router-link to="/types">انواع المراكز</router-link>
                    </li>

                    <li>
                        <router-link to="/centers">المراكز</router-link>
                    </li>

                    <li>
                        <router-link to="/tables">الجداول</router-link>
                    </li>

                    <li>
                        <router-link to="/fields">الحقول</router-link>
                    </li>

                    <li>
                        <router-link to="/violations">المخالفات</router-link>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</div>
