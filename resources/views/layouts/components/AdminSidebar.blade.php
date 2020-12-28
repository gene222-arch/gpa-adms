<div class="bg-light border-right" id="layout-sidebar-wrapper">
    <div class="sidebar-heading">Start Bootstrap </div>
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Cras justo odio
          <span class="badge badge-primary badge-pill">14</span>
        </li>
        <li class="list-group-item <?php echo activeSidebarLink(3,'user-management') ?>">
            <div class="row d-flex justify-content-between w-100">
                <div class="col">
                    <a href="#UserManageMent" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle" >User Management</a>
                </div>
                <div>
                    <a href="#UserManageMent" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-caret-down"></i></a>
                </div>
            </div>
        </li>
        <ul class="collapse list-unstyled" id="UserManageMent">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.dashboard.user-management.permissions') }}">Permissions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard.user-management.roles') }}">Roles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Users</a>
            </li>
        </ul>
        <li class="list-group-item <?php echo activeSidebarLink(3,'relief-assistance-mngmt') ?>">
            <div class="row d-flex justify-content-between w-100">
                <div class="col">
                    <a href="#RAMsubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Relief Assistance</a>
                </div>
                <div>
                    <a href="#RAMsubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-caret-down"></i></a>
                </div>
            </div>
        </li>
        <ul class="collapse list-unstyled" id="RAMsubMenu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard.relief-assistance-mngmt.volunteers', [1]) }}">Volunteer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Position 2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Position 3</a>
            </li>
        </ul>

        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo activeSidebarLink(3,'URL') ?>">
            Morbi leo risus
            <span class="badge badge-primary badge-pill ">1</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="">Logout</a>
            <span class="badge badge-primary badge-pill">1</span>
        </li>
      </ul>
</div>
