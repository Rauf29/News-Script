@if(Auth::guard('admin')->user()->sectionCheck('menu_builder'))
<li>
    <a href="{{ route('admin.menu.builder') }}" >
        <i class="fas fa-bars"></i>{{ __('Menu Builder') }}
    </a>
</li>
@endif


@if(Auth::guard('admin')->user()->sectionCheck('pages'))   
<li>
    <a href="#page" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fa fa-window-restore"></i>{{ __('Pages') }}
    </a>
    <ul class="collapse list-unstyled" id="page" data-parent="#accordion">
        <li>
            <a href="{{ route('admin.page.create') }}"><i class="fas fa-angle-double-right"></i><span>{{ __('Add Page') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin.page.index') }}"><i class="fas fa-angle-double-right"></i><span>{{ __('Pages') }}</span></a>
        </li>
    </ul>
</li>
@endif


@if (Auth::guard('admin')->user()->sectionCheck('categories'))   
<li>
    <a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fa fa-folder-open"></i>{{ __('Categories') }}
    </a>
    <ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
        <li>
            <a href="{{ route('categories.index') }}"><i class="fas fa-angle-double-right"></i><span>{{ __('Categories') }}</span></a>
        </li>
        <li>
            <a href="{{ route('subcategories.index') }}"><i class="fas fa-angle-double-right"></i><span>{{ __('SubCategories') }}</span></a>
        </li>
    </ul>
</li>
@endif


<li>
    <a href="{{ route('admin.post.format') }}" >
        <i class="fa fa-file"></i>{{ __('Add Post') }}
    </a>
</li>


@if (Auth::guard('admin')->user()->sectionCheck('add_gallery'))   
<li>
    <a href="#gallery" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-image"></i>{{ __('Galleries') }}
    </a>
    <ul class="collapse list-unstyled" id="gallery" data-parent="#accordion">
        <li>
            <a href="{{ route('image.album.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Image Album') }}</span></a>
        </li>
        <li>
            <a href="{{ route('image.category.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Image Category') }}</span></a>
        </li>
        <li>
            <a href="{{ route('image.gallery.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Image Gallery') }}</span></a>
        </li>
    </ul>
</li>
@endif


@if (Auth::guard('admin')->user()->sectionCheck('posts'))   
<li>
    <a href="#menu4" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fa fa-bars"></i>{{ __('Posts') }}
    </a>
    <ul class="collapse list-unstyled" id="menu4" data-parent="#accordion">
        <li>
            <a href="{{ route('post.index') }}"><span>{{ __('Posts') }}</span></a>
        </li>
        <li>
            <a href="{{ route('slider.index') }}"><span>{{ __('Slider Posts') }}</span></a>
        </li>
        <li>
            <a href="{{ route('feature.index') }}"><span>{{ __('Featured Posts') }}</span></a>
        </li>
        <li>
            <a href="{{ route('breaking.index') }}"><span>{{ __('Breaking News') }}</span></a>
        </li>
        <li>
            <a href="{{ route('pending.index') }}"><span>{{ __('Pending Posts') }}</span></a>
        </li>

    </ul>
</li>
@endif


@if (Auth::guard('admin')->user()->sectionCheck('schedule_post'))    
<li>
    <a href="{{ route('schedule.index') }}"><span><i class="fa fa-calendar" aria-hidden="true"></i>{{ __('Schedule Post') }}</span></a>
</li>
@endif


@if (Auth::guard('admin')->user()->sectionCheck('drafts'))    
<li>
    <a href="{{ route('draft.index') }}"><span><i class="fab fa-firstdraft"></i>{{ __('Drafts') }}</span></a>
</li>
@endif


@if (Auth::guard('admin')->user()->sectionCheck('rss_feeds'))   
<li>
    <a href="#rss" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-rss"></i>{{ __('Rss Feeds') }}
    </a>
    <ul class="collapse list-unstyled" id="rss" data-parent="#accordion">
        <li>
            <a href="{{ route('rss.create') }}"><span>{{ __('Import Rss Feeds') }}</span></a>
        </li>
        <li>
            <a href="{{ route('rss.index') }}"><span>{{ __('Rss Feeds') }}</span></a>
        </li>
    </ul>
</li>
@endif






@if (Auth::guard('admin')->user()->sectionCheck('general_settings'))    
<li>
    <a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-cogs"></i>General Settings
    </a>
    <ul class="collapse list-unstyled" id="general" data-parent="#accordion">
        <li>
            <a href="{{route('admin.generalsettings.logo')}}"><span>Logo</span></a>
        </li>
        <li>
            <a href="{{route('admin.language.index')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Website Language')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.languagelogo.index')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Language Base Logo')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.favicon')}}"><span>Favicon</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.loader')}}"><span>loader</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.websiteContent')}}"><span>Website Setting & Adds</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.footer')}}"><span>Footer</span></a>
        </li>
        

    </ul>
</li>
@endif


@if (Auth::guard('admin')->user()->sectionCheck('social_settings'))    
<li>
    <a href="#socials" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-paper-plane"></i>{{ __('Social Settings') }}
    </a>
    <ul class="collapse list-unstyled" id="socials" data-parent="#accordion">
            <li><a href="{{route('social.link.index')}}"><span>{{ __('Social Links') }}</span></a></li>
    </ul>
</li>
@endif


@if (Auth::guard('admin')->user()->sectionCheck('emails_settings'))    
<li>
    <a href="#emails" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-at"></i>Email Settings
    </a>
    <ul class="collapse list-unstyled" id="emails" data-parent="#accordion">
        <li><a href="{{route('admin.email.config')}}"><span>Email Configurations</span></a></li>
        <li><a href="{{ route('admin.subscriber.index') }}"><span>Subscribers</span></a></li>    
    </ul>
</li>
@endif


@if (Auth::guard('admin')->user()->sectionCheck('seo_tools'))   
<li>
    <a href="#seoTools" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-wrench"></i>SEO Tools
    </a>
    <ul class="collapse list-unstyled" id="seoTools" data-parent="#accordion">
        <li>
            <a href="{{ route('seo.google.analytics') }}"><span>Google Analytics</span></a>
        </li
        >
        <li>
            <a href="{{ route('seo.meta.keywords') }}"><span>Website Meta Tag Option</span></a>
        </li>
    </ul>
</li>
@endif


@if (Auth::guard('admin')->user()->sectionCheck('site_map'))  
<li>
    <a href="{{ route('admin.sitemap.all') }}" class=" wave-effect"><i class="fas fa-sitemap"></i>{{ __('Site Map') }}</a>
</li>
@endif



@if (Auth::guard('admin')->user()->sectionCheck('role_management'))
<li>
    <a href="{{ route('admin.role.index') }}" class=" wave-effect"><i class="fas fa-user-tag"></i>{{ __('Role Management') }}</a>
</li>  
@endif


@if (Auth::guard('admin')->user()->sectionCheck('user_management'))
<li>
    <a href="{{ route('admin.staff.index') }}" class=" wave-effect"><i class="fas fa-user-secret"></i>{{ __('User Management') }}</a>
</li>   
@endif


@if (Auth::guard('admin')->user()->sectionCheck('cache_management'))
<li>
    <a href="{{ route('admin.cache.clear') }}" class=" wave-effect"><i class="fa fa-database"></i>{{ __('Clear Cache') }}</a>
</li>    
@endif