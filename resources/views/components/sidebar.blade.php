<div class="sidebar bg-dark text-white p-3"
   style="width: 250px; height: 100vh; position: fixed; top: 0; left: 0;">

   <h4 class="text-center mb-4">Admin Panel</h4>

   <ul class="nav flex-column">

      <!-- Dashboard -->
      <li>
         <a href="/dashboard" class="nav-link text-white">
            <i class="bi bi-speedometer2"></i> Dashboard
         </a>
      </li>

      <!-- Companies -->
      <li>
         <a href="{{ route('companies.index') }}" class="nav-link text-white">
            <i class="bi bi-building"></i> Companies
         </a>
      </li>

      <!-- Billboards Menu -->
      <li class="nav-item">
         <a class="nav-link text-white d-flex justify-content-between"
            data-bs-toggle="collapse"
            href="#menu-billboards"
            role="button"
            aria-expanded="false"
            aria-controls="menu-billboards">
            <span><i class="bi bi-display"></i> Billboards</span>
            <i class="bi bi-chevron-down small"></i>
         </a>
         <div class="collapse" id="menu-billboards">
            <ul class="nav flex-column ms-3">
               @php
               $count = Auth::user()->screen_count ?? 0;
               @endphp

               @for ($i = 1; $i <= $count; $i++)
                  <li><a href="{{ route('image.upload', ['screen_id' => $i]) }}" class="nav-link text-white"> Screen {{ $i }}</a></li>
               @endfor
            </ul>
         </div>
      </li>
      <!-- Designer -->
      <li>
         <a href="/designer" class="nav-link text-white">
            <i class="bi bi-easel"></i> Designer
         </a>
      </li>

      <!-- Settings -->
      <li>
         <a href="#" class="nav-link text-white"><i class="bi bi-gear"></i> Settings</a>
      </li>
   </ul>
</div>
