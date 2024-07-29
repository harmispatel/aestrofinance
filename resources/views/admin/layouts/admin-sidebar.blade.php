 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     @php
         $urls = [];
         $urls[] = Request::segment(2);
         $urls[] = Request::segment(3);
         $url = array_filter($urls);
         $role_id = Auth::user()->role_id;
         $permission_ids = App\Models\RoleHasPermissions::where('role_id', $role_id)->pluck('permission_id')->toArray();
         $role = Spatie\Permission\Models\Permission::where('name', 'roles')->first();
         $user = Spatie\Permission\Models\Permission::where('name', 'users')->first();

     @endphp

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link
            {{-- Active Tab Class --}}
            {{ in_array('dashboard', $url) ? 'active-tab' : '' }}"
                 href="{{ route('dashboard') }}">
                 <i
                     class="bi bi-grid
                {{-- Icon Tab Class --}}
                {{ in_array('dashboard', $url) ? 'icon-tab' : '' }}"></i>
                 <span>{{ __('Dashboard') }}</span>
             </a>
         </li>

         <li class="nav-item">
             <a href="{{ route('intraday') }}"
                 class="nav-link {{ Route::currentRouteName() == 'intraday' || Route::currentRouteName() == 'intraday.create' || Route::currentRouteName() == 'intraday.edit' || Route::currentRouteName() == 'intraday.intraView' ? 'active-tab' : '' }}">
                 <i
                     class="bi bi-browser-firefox {{ Route::currentRouteName() == 'intraday' || Route::currentRouteName() == 'intraday.create' || Route::currentRouteName() == 'intraday.edit' || Route::currentRouteName() == 'intraday.intraView' ? 'icon-tab' : '' }}"></i><span>{{ trans('label.IntraDay') }}</span>
             </a>
         </li>

         <li class="nav-item">
             <a href="{{ route('grahs.index') }}"
                 class="nav-link {{ Route::currentRouteName() == 'grahs.index' || Route::currentRouteName() == 'grahs.create' || Route::currentRouteName() == 'grahs.edit' ? 'active-tab' : '' }}">
                 <i
                     class="bi bi-bullseye {{ Route::currentRouteName() == 'grahs.index' || Route::currentRouteName() == 'grahs.create' || Route::currentRouteName() == 'grahs.edit' ? 'icon-tab' : '' }}"></i><span>{{ trans('label.Grah') }}</span>
             </a>
         </li>

         <li class="nav-item">
             <a href="{{ route('grahsdata.index') }}"
                 class="nav-link {{ Route::currentRouteName() == 'grahsdata.index' || Route::currentRouteName() == 'grahsdata.create' || Route::currentRouteName() == 'grahsdata.edit' ? 'active-tab' : '' }}">
                 <i
                     class="bi bi-browser-edge {{ Route::currentRouteName() == 'grahsdata.index' || Route::currentRouteName() == 'grahsdata.create' || Route::currentRouteName() == 'grahsdata.edit' ? 'icon-tab' : '' }}"></i><span>{{ trans('label.GrahWiseData') }}</span>
             </a>
         </li>

               {{-- Current Nifty Price --}}
               <li class="nav-item">
                <a href="{{ route('currentNifty') }}"
                    class="nav-link {{ Route::currentRouteName() == 'currentNifty' ? 'active-tab' : '' }}">
                    <i
                        class="bi bi-boxes {{ Route::currentRouteName() == 'currentNifty' ? 'icon-tab' : '' }}"></i><span>Current Level</span>
                </a>
           </li>
           
         {{-- Night hora --}}
         <li class="nav-item">
             <a href="{{ route('nightgrahsdata.index') }}"
                 class="nav-link {{ Route::currentRouteName() == 'nightgrahsdata.index' || Route::currentRouteName() == 'nightgrahsdata.create' || Route::currentRouteName() == 'nightgrahsdata.edit' ? 'active-tab' : '' }}">
                 <i
                     class="bi bi-mask {{ Route::currentRouteName() == 'nightgrahsdata.index' || Route::currentRouteName() == 'nightgrahsdata.create' || Route::currentRouteName() == 'nightgrahsdata.edit' ? 'icon-tab' : '' }}"></i><span>Night
                     Hora GrahWiseData</span>
             </a>
         </li>

         <li class="nav-item">
             <a href="{{ route('gannStokes.index') }}"
                 class="nav-link {{ Route::currentRouteName() == 'gannStokes.index' ? 'active-tab' : '' }}">
                 <i
                     class="bi bi-gem {{ Route::currentRouteName() == 'gannStokes.index' ? 'icon-tab' : '' }}"></i><span>Gann
                     Stocks</span>
             </a>
         </li>

         <li class="nav-item">
             <a href="{{ route('importantGrah.index') }}"
                 class="nav-link {{ Route::currentRouteName() == 'importantGrah.index' ? 'active-tab' : '' }}">
                 <i
                     class="bi bi-flower1 {{ Route::currentRouteName() == 'importantGrah.index' ? 'icon-tab' : '' }}"></i><span>{{ trans('label.Important Grah') }}</span>
             </a>
         </li>

         <li class="nav-item">
             <a href="{{ route('bhadra.index') }}"
                 class="nav-link {{ Route::currentRouteName() == 'bhadra.index' ? 'active-tab' : '' }}">
                 <i
                     class="bi bi-exclude {{ Route::currentRouteName() == 'bhadra.index' ? 'icon-tab' : '' }}"></i><span>Bhadra
                     Data</span>
             </a>
         </li>

         {{-- User Tab --}}
         @if (in_array($role->id, $permission_ids) || in_array($user->id, $permission_ids))
             <li class="nav-item">
                 @php
                     $userRoutes = ['roles', 'roles.create', 'roles.edit', 'users', 'users.create', 'users.edit'];
                 @endphp
                 <a class="nav-link {{ in_array(Route::currentRouteName(), $userRoutes) ? 'active-tab' : 'collapsed' }}"
                     data-bs-target="#users-nav" data-bs-toggle="collapse" href="#"
                     aria-expanded="{{ in_array(Route::currentRouteName(), $userRoutes) ? 'true' : 'false' }}">
                     <i
                         class="fa-solid fa-users {{ in_array(Route::currentRouteName(), $userRoutes) ? 'icon-tab' : '' }}"></i>
                     <span>Users</span>
                     <i
                         class="bi bi-chevron-down ms-auto {{ in_array(Route::currentRouteName(), $userRoutes) ? 'icon-tab' : '' }}"></i>
                 </a>

                 <ul id="users-nav"
                     class="nav-content sidebar-ul collapse {{ in_array(Route::currentRouteName(), $userRoutes) ? 'show' : '' }}"
                     data-bs-parent="#sidebar-nav">
                     @if (in_array($role->id, $permission_ids))
                         <li>
                             <a href="{{ route('roles') }}"
                                 class="{{ in_array(Route::currentRouteName(), ['roles', 'roles.create', 'roles.edit']) ? 'active-link' : '' }}">
                                 <i
                                     class="{{ in_array(Route::currentRouteName(), ['roles', 'roles.create', 'roles.edit']) ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i>
                                 <span>Roles</span>
                             </a>
                         </li>
                     @endif
                     @if (in_array($user->id, $permission_ids))
                         <li>
                             <a href="{{ route('users') }}"
                                 class="{{ in_array(Route::currentRouteName(), ['users', 'users.create', 'users.edit']) ? 'active-link' : '' }}">
                                 <i
                                     class="{{ in_array(Route::currentRouteName(), ['users', 'users.create', 'users.edit']) ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i>
                                 <span>Users</span>
                             </a>
                         </li>
                     @endif
                 </ul>
             </li>
         @endif

         <!-- End Dashboard Nav -->

         <li class="nav-item">
             @php
                 $settingRoutes = ['settingDetail', 'settingEdit'];
             @endphp
             <a class="nav-link {{ in_array(Route::currentRouteName(), $settingRoutes) ? 'active-tab' : 'collapsed' }}"
                 data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#"
                 aria-expanded="{{ in_array(Route::currentRouteName(), $settingRoutes) ? 'true' : 'false' }}">
                 <i class="bi bi-gear {{ in_array(Route::currentRouteName(), $settingRoutes) ? 'icon-tab' : '' }}"></i>
                 <span>Setting</span>
                 <i
                     class="bi bi-chevron-down ms-auto {{ in_array(Route::currentRouteName(), $settingRoutes) ? 'icon-tab' : '' }}"></i>
             </a>

             <ul id="settings-nav"
                 class="nav-content sidebar-ul collapse {{ in_array(Route::currentRouteName(), $settingRoutes) ? 'show' : '' }}"
                 data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('settingDetail') }}"
                         class="{{ in_array(Route::currentRouteName(), $settingRoutes) ? 'active-link' : '' }}">
                         <i
                             class="{{ in_array(Route::currentRouteName(), $settingRoutes) ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i>
                         <span>User Detail</span>
                     </a>
                 </li>
             </ul>
         </li>

         {{-- ganstocks 1 month before data --}}
         <li class="nav-item">
             <a href="{{ route('gannStokes.beforemotnh') }}"
                 class="nav-link {{ Route::currentRouteName() == 'gannStokes.beforemotnh' ? 'active-tab' : '' }}">
                 <i
                     class="bi bi-award-fill {{ Route::currentRouteName() == 'gannStokes.beforemotnh' ? 'icon-tab' : '' }}"></i><span>Before
                     1 month GanStocks</span>
             </a>
         </li>

            {{-- Trayodashi Price --}}
            <li class="nav-item">
                <a href="{{ route('trayodashi.index') }}"
                    class="nav-link {{ Route::currentRouteName() == 'trayodashi.index' || Route::currentRouteName() == 'trayodashi.create' || Route::currentRouteName() == 'trayodashi.edit' ? 'active-tab' : '' }}">
                    <i
                        class="bi bi-tropical-storm {{ Route::currentRouteName() == 'trayodashi.index' || Route::currentRouteName() == 'trayodashi.create' || Route::currentRouteName() == 'trayodashi.edit' ? 'icon-tab' : '' }}"></i><span>Trayodashi</span>
                </a>
           </li>
            {{-- Amavashya dates --}}
            <li class="nav-item">
                <a href="{{ route('amavasya.index') }}"
                    class="nav-link {{ Route::currentRouteName() == 'amavasya.index' || Route::currentRouteName() == 'amavasya.create' || Route::currentRouteName() == 'amavasya.edit' ? 'active-tab' : '' }}">
                    <i
                        class="bi bi-cloud-moon-fill {{ Route::currentRouteName() == 'amavasya.index' || Route::currentRouteName() == 'amavasya.create' || Route::currentRouteName() == 'amavasya.edit' ? 'icon-tab' : '' }}"></i><span>Amavasya</span>
                </a>
           </li>

           {{-- Current week buy Stocks --}}
           <li class="nav-item">
            <a href="{{ route('currentweekstock') }}"
                class="nav-link {{ Route::currentRouteName() == 'currentweekstock' ? 'active-tab' : '' }}">
                <i
                    class="bi bi-graph-up {{ Route::currentRouteName() == 'currentweekstock' ? 'icon-tab' : '' }}"></i><span>CurrentWeek Stocks</span>
            </a>
       </li>
     </ul>

 </aside>
 <!-- End Sidebar-->
