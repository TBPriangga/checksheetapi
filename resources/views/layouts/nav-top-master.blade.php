<div class="row border-bottom">
  <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
      <li>
        <span class="m-r-sm welcome-message" style="font-weight:bold;">{{auth()->user()->name}}</span>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
          <i class="fa fa-bell"></i>  
          <span class="label label-danger">{{$notificationData['notifications_count'] ?? 0}}</span>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
          @isset($notificationData)
              @if (isset($notificationData['notif_npp_delay_start']) && count($notificationData['notif_npp_delay_start']) != 0)
                  @foreach ($notificationData['notif_npp_delay_start'] as $projectName => $items)
                    @php
                    $arr_id = [];
                    foreach ($items as $key => $value) {
                      array_push($arr_id, $value['id']);
                    }
                    @endphp
                    <li>
                      <a href="{{ route($notificationData['link_delay_npp'], ['id' => implode(",",$arr_id) ?? '' ]) }}">
                          {{$projectName;}} Delay Start ({{count($items);}})
                      </a>
                    </li>
                  @endforeach
                  <li class="dropdown-divider"></li> 
              @endif
              @if (isset($notificationData['notif_npp_delay_end']) && count($notificationData['notif_npp_delay_end']) != 0)
                  @foreach ($notificationData['notif_npp_delay_end'] as $projectName => $items)
                    @php
                    $arr_id = [];
                    foreach ($items as $key => $value) {
                      array_push($arr_id, $value['id']);
                    }
                    @endphp
                    <li>
                      <a href="{{ route($notificationData['link_delay_npp'], ['id' => implode(",",$arr_id) ?? '' ]) }}">
                          {{$projectName;}} Delay End ({{count($items);}})
                      </a>
                    </li>
                  @endforeach
                  <li class="dropdown-divider"></li> 
              @endif
              @if (isset($notificationData['notif_npp_closest_start']) && count($notificationData['notif_npp_closest_start']) != 0)
                @foreach ($notificationData['notif_npp_closest_start'] as $projectName => $items)
                  @php
                  $arr_id = [];
                  foreach ($items as $key => $value) {
                    array_push($arr_id, $value['id']);
                  }
                  @endphp
                  <li>
                    <a href="{{ route($notificationData['link_delay_npp'], ['id' => implode(",",$arr_id) ?? '' ]) }}">
                        {{$projectName;}} will start ({{count($items);}})
                    </a>
                  </li>
                @endforeach
                <li class="dropdown-divider"></li>
              @endif
              @if (isset($notificationData['notif_npp_closest_end']) && count($notificationData['notif_npp_closest_end']) != 0)
                @foreach ($notificationData['notif_npp_closest_end'] as $projectName => $items)
                  @php
                  $arr_id = [];
                  foreach ($items as $key => $value) {
                    array_push($arr_id, $value['id']);
                  }
                  @endphp
                  <li>
                    <a href="{{ route($notificationData['link_delay_npp'], ['id' => implode(",",$arr_id) ?? '' ]) }}">
                        {{$projectName;}} will end ({{count($items);}})
                    </a>
                  </li>
                @endforeach
                <li class="dropdown-divider"></li> 
              @endif
          @endisset
        </ul>
      </li>

      @auth
      <li>
        <a href="{{ route('to.portal') }}">
          <i class="fa fa-sign-out"></i> Log out
        </a>
      </li>
      @endauth
      @guest
      <li>
        <a href="{{ route('login.perform') }}">
          <i class="fa fa-sign-in"></i> Log in
        </a>
      </li>
      @endguest
    </ul>

  </nav>
</div>