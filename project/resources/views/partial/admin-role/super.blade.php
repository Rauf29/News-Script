<li>
    <a href="{{ route('admin.menu.builder') }}" >
        <i class="fas fa-bars"></i>{{ __('Menu Builder') }}
    </a>
</li>

<li>
    <a href="#page" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fa fa-window-restore"></i>{{ __('Pages') }}
    </a>
    <ul class="collapse list-unstyled" id="page" data-parent="#accordion">
        <li>
            <a href="{{ route('admin.page.create') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Add Page') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin.page.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Pages') }}</span></a>
        </li>
    </ul>
</li>


<li>
    <a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fa fa-folder-open"></i>{{ __('Categories') }}
    </a>
    <ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
        <li>
            <a href="{{ route('categories.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Categories') }}</span></a>
        </li>
        <li>
            <a href="{{ route('subcategories.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('SubCategories') }}</span></a>
        </li>
    </ul>
</li>


<li>
    <a href="{{ route('admin.post.format') }}" >
        <i class="fa fa-file"></i>{{ __('Add Post') }}
    </a>
</li>
 

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



<li>
    <a href="#menu4" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fa fa-bars"></i>{{ __('Posts') }}
    </a>
    <ul class="collapse list-unstyled" id="menu4" data-parent="#accordion">
        <li>
            <a href="{{ route('post.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('All Posts') }}</span></a>
        </li>
        <li>
            <a href="{{ route('slider.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Slider Posts') }}</span></a>
        </li>
        <li>
            <a href="{{ route('feature.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Featured Posts') }}</span></a>
        </li>
        <li>
            <a href="{{ route('breaking.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Breaking News') }}</span></a>
        </li>
        <li>
            <a href="{{ route('pending.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Pending Posts') }}</span></a>
        </li>

    </ul>
</li>

<li>
    <a href="{{ route('schedule.index') }}"><span><i class="fa fa-calendar" aria-hidden="true"></i>{{ __('Schedule Post') }}</span></a>
</li>



<li>
    <a href="{{ route('draft.index') }}"><span><i class="fab fa-firstdraft"></i>{{ __('Drafts') }}</span></a>
</li>


<li>
    <a href="#rss" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-rss"></i>{{ __('Rss Feeds') }}
    </a>
    <ul class="collapse list-unstyled" id="rss" data-parent="#accordion">
        <li>
            <a href="{{ route('rss.create') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Import Rss Feeds') }}</span></a>
        </li>
        <li>
            <a href="{{ route('rss.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Rss Feeds') }}</span></a>
        </li>
    </ul>
</li>

<li>
    <a href="#polls" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fa fa-poll"></i>{{ __('Polls') }}
    </a>
    <ul class="collapse list-unstyled" id="polls" data-parent="#accordion">
        <li>
            <a href="{{ route('addPolls.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Polls') }}</span></a>
        </li>
        <li>
            <a href="{{ route('addPolls.create') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Add Poll') }}</span></a>
        </li>
    </ul>
</li>

<li>
    <a href="#widgets" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fa fa-puzzle-piece"></i>{{ __('Widgets') }}
    </a>
    <ul class="collapse list-unstyled" id="widgets" data-parent="#accordion">
        <li>
            <a href="{{ route('widget.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Widgets') }}</span></a>
        </li>
        <li>
            <a href="{{ route('widget.create') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Add Widget') }}</span></a>
        </li>
        <li>
            <a href="{{ route('widget.settings') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Widget Settings') }}</span></a>
        </li>
    </ul>
</li>

<li>
    <a href="#ads" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fa fa-ad"></i>{{ __('Ads') }}
    </a>
    <ul class="collapse list-unstyled" id="ads" data-parent="#accordion">
        <li>
            <a href="{{ route('ads.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Ads') }}</span></a>
        </li>
        <li>
            <a href="{{ route('ads.create') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Add Ad') }}</span></a>
        </li>
    </ul>
</li>

<li>
    <a href="{{ route('fonts.index') }}" >
        <i class="fa fa-font"></i>{{ __('Fonts') }}
    </a>
</li>

<li>
    <a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-cogs"></i>{{__('General Settings')}}
    </a>
    <ul class="collapse list-unstyled" id="general" data-parent="#accordion">
	        <li>
            <a href="{{route('admin.generalsettings.websiteContent')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Website Seeting & Adds')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.logo')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Logo')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.language.index')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Website Language')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.languagelogo.index')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Language Base Logo')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.favicon')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Favicon')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.loader')}}"><span><i class="fas fa-angle-double-right"></i>{{__('loader')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.footer')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Footer')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.errorPage')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Error Page')}}</span></a>
        </li>
        <li>
            <a href="{{route('admin.generalsettings.popularTags')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Popular Tags')}}</span></a>
        </li>

    </ul>
</li>

   
<li>
    <a href="#socials" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-paper-plane"></i>{{ __('Social Settings') }}
    </a>
    <ul class="collapse list-unstyled" id="socials" data-parent="#accordion">
            <li><a href="{{route('social.link.index')}}"><span><i class="fas fa-angle-double-right"></i>{{ __('Social Links') }}</span></a></li>
            <li><a href="{{route('social.settings.google')}}"><span><i class="fas fa-angle-double-right"></i>{{ __('Google Login') }}</span></a></li>
            <li><a href="{{route('social.settings.facebook')}}"><span><i class="fas fa-angle-double-right"></i>{{ __('Facebook Login') }}</span></a></li>
    </ul>
</li>

  
<li>
    <a href="#emails" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-at"></i>{{__('Email Settings')}}
    </a>
    <ul class="collapse list-unstyled" id="emails" data-parent="#accordion">
        <li><a href="{{route('admin.email.config')}}"><span><i class="fas fa-angle-double-right"></i>{{__('Email Configurations')}}</span></a></li>
        <li><a href="{{ route('admin.subscriber.index') }}"><span><i class="fas fa-angle-double-right"></i>{{__('Subscribers')}}</span></a></li>  
        <li><a href="{{ route('admin.email.group') }}"><span><i class="fas fa-angle-double-right"></i>{{__('Email Group')}}</span></a></li>  
    </ul>
</li>


<li>
    <a href="#seoTools" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-wrench"></i>{{__('SEO Tools')}}
    </a>
    <ul class="collapse list-unstyled" id="seoTools" data-parent="#accordion">
        <li>
            <a href="{{ route('seo.google.analytics') }}"><span><i class="fas fa-angle-double-right"></i>{{__('Google Analytics')}}</span></a>
        </li
        >
        <li>
            <a href="{{ route('seo.meta.keywords') }}"><span><i class="fas fa-angle-double-right"></i>{{__('Website Meta Tag Option')}}</span></a>
        </li>
    </ul>
</li>

<li>
    <a href="#sitemap" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-sitemap"></i>{{ __('Site Map') }}
    </a>
    <ul class="collapse list-unstyled" id="sitemap" data-parent="#accordion">
        <li>
            <a href="{{ route('admin.sitemap.all') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('All Sitemaps') }}</span></a>
        </li>
        <li>
            <a href="{{ route('sitemap.index') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Sitemap Index') }}</span></a>
        </li>
        <li>
            <a href="{{ route('sitemap.categories') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Categories Sitemap') }}</span></a>
        </li>
        <li>
            <a href="{{ route('sitemap.subcategories') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Subcategories Sitemap') }}</span></a>
        </li>
        <li>
            <a href="{{ route('sitemap.posts') }}"><span><i class="fas fa-angle-double-right"></i>{{ __('Posts Sitemap') }}</span></a>
        </li>
    </ul>
</li>



<li>
    <a href="{{ route('admin.role.index') }}" class=" wave-effect"><i class="fas fa-user-tag"></i>{{ __('Role Management') }}</a>
</li>  


<li>
    <a href="#users" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-wrench"></i>{{__('Users Management')}}
    </a>
    <ul class="collapse list-unstyled" id="users" data-parent="#accordion">
        <li>
            <a href="{{ route('admin.staff.index') }}"><span><i class="fas fa-angle-double-right"></i>{{__('Users')}}</span></a>
        </li>
        <li>
            <a href="{{ route('admin.administator.index') }}"><span><i class="fas fa-angle-double-right"></i>{{__('Administrator')}}</span></a>
        </li>
    </ul>
</li>
<li>
    <a href="https://techpeaks.com.bd/contact"><span><i class="fab fa-facebook-messenger"></i>Support</span></a>
</li>

<li>
    <a href="{{ route('admin.cache.clear') }}" class=" wave-effect"><i class="fa fa-database"></i>{{ __('Clear Cache') }}</a>
</li>    