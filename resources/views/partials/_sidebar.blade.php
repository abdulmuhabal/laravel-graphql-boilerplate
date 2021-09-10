<div id="sidebar-wrapper" class="d-print-none bg-primary">
  <div class="simplebar-scroll-content">
    <div class="simplebar-content">
      <div class="brand-logo">
        <a href="#">
          <img src="{{ asset('logo.png')}}" class="logo-icon mt-4" alt="logo icon" width="150px">
        </a>
      </div>
      <ul class="sidebar-menu mt-4 text-right text-theme-color-2">
        <li class="sidebar-header">{{ __('lang.menu') }}</li>
        <li> <a class="" href="{{ route('admins.dashboard.index') }}">{{ __('lang.dashboard') }} <i class="fa fa-dashboard"></i></a> </li>
        <li> <a class="" href="{{ route('admins.clients.index') }}">{{ __('lang.clients') }} <i class="fa fa-user"></i></a> </li>
        <li>
          <a class="text-theme-color-2" href="javaScript:void();">
           <span>{{ __('lang.requests') }}</span>
            <i class="fa fa-angle-left float-left"></i><i class="fa fa-dot-circle-o" aria-hidden="true"></i>  
          </a>
          <ul class="sidebar-submenu">
            <li> <a class="text-theme-color-2" href="{{ route('admins.requests.calls') }}">{{ __('lang.call_requests') }} <i class="fa fa-phone-square" aria-hidden="true"></i></a> </li>
            <li> <a class="text-theme-color-2" href="{{ route('admins.requests.emails') }}">{{ __('lang.email_requests') }} <i class="fa fa-envelope-open-o" aria-hidden="true"></i></a> </li>
            <li> <a class="text-theme-color-2" href="{{ route('admins.requests.chats') }}">{{ __('lang.chat_requests') }} <i class="fa fa-comments" aria-hidden="true"></i></a> </li>
          </ul>
        </li>
        <li>
          <a class="text-theme-color-2" href="javaScript:void();">
           <span>{{ __('lang.CRM') }}</span>
            <i class="fa fa-angle-left float-left"></i><i class="fa fa-gears"></i>
          </a>
          <ul class="sidebar-submenu">
            <li> <a class="text-theme-color-2" href="{{ route('admins.contact-us.index') }}">{{ __('lang.contact_us') }} <i class="fa fa-phone"></i></a> </li>
            <li> <a class="text-theme-color-2" href="{{ route('admins.terms.index') }}">{{ __('lang.terms_and_conditions') }} <i class="fa fa-file-text"></i></a> </li>
            <li> <a class="text-theme-color-2" href="{{ route('admins.about-app.index') }}">{{ __('lang.about_the_app') }} <i class="fa fa-file-text"></i></a> </li>
            <li> <a class="text-theme-color-2" href="{{ route('admins.social-media.index') }}">{{ __('lang.social_media_accounts') }} <i class="fa fa-question"></i></a> </li>

          </ul>
        </li>
        <li> <a class="" href="{{ route('admins.general-settings.index') }}">{{ __('lang.general_settings') }} <i class="fa fa-gear"></i></a> </li>
      </ul>

    </div>
  </div>
</div>