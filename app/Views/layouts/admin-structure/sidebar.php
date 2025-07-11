<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= base_url('dashboard') ?>" class="brand-link">
    <span class="brand-text font-weight-light">School Admin</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
	<li class="nav-item"><a href="<?= base_url('dashboard') ?>" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
        <li class="nav-item"><a href="<?= base_url('teacher_management') ?>" class="nav-link"><i class="nav-icon fas fa-chalkboard-teacher"></i><p>Teacher Management</p></a></li>
        <li class="nav-item"><a href="<?= base_url('ad-student') ?>" class="nav-link"><i class="nav-icon fas fa-user-graduate"></i><p>Student Management</p></a></li>
        <li class="nav-item"><a href="<?= base_url('calendar') ?>" class="nav-link"><i class="nav-icon fas fa-calendar-alt"></i><p>Calender</p></a></li>
        <!-- Add more sidebar items similarly -->
      </ul>
    </nav>
  </div>
</aside>
