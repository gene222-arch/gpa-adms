<div class="bg-light border-right" id="layout-sidebar-wrapper">
    <div class="sidebar-heading">Start Bootstrap </div>
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Cras justo odio
          <span class="badge badge-primary badge-pill">14</span>
        </li>

        <div class="relief-mngmt">
            <li class="list-group-item">
                <div class="row d-flex justify-content-between w-100">
                    <div class="col">
                        <a href="#UserManageMent" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Relief Management</a>
                    </div>
                    <div>
                        <a href="#UserManageMent" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-caret-down"></i></a>
                    </div>
                </div>
            </li>
            <ul class="collapse list-unstyled" id="UserManageMent">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('volunteer.relief-mngmt.on-process-and-create', [Auth::id()]) }}">On Process and Create</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Approved</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Dispatched</a>
                </li>
            </ul>
        </div>
      </ul>
</div>
