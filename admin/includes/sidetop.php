<!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="dashboard.php">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="img/logo.jpg" alt="homepage" style="width: 60px;height:60px;object-fit: contain;" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <h4 style="color: #cda45e" class="mt-3">E.PRODUCTION</h4>
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light  d-block d-md-none"
                        href="javascript:void(0)" style="color: #cda45e"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav d-none d-md-block d-lg-none">
                        <li class="nav-item">
                            <a class="nav-toggler nav-link waves-effect waves-light text-white"
                                href="javascript:void(0)" style="color: #cda45e"><i class="ti-menu ti-close"></i></a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                            <a class="profile-pic" href="#">
                               <span class="text-white font-medium"><?php echo $userInfo['Firstname']." ".$userInfo['Lastname']?></span>
                           </a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item pt-2 ">
                            <a class="<?php echo ($active == 'dashboard') ? 'active' : '' ?> sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php"
                                aria-expanded="false">
                                <i class="far fa-clock" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="<?php echo ($active == 'events') ? 'active' : '' ?>sidebar-link waves-effect waves-dark sidebar-link" href="events.php"
                                aria-expanded="false">
                                <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                                <span class="hide-menu">Events</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="<?php echo ($active == 'inclussions') ? 'active' : '' ?>sidebar-link waves-effect waves-dark sidebar-link" href="package-inclussion.php"
                                aria-expanded="false">
                                <i class="fa fa-boxes" aria-hidden="true"></i>
                                <span class="hide-menu">Package Inclussions</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="<?php echo ($active == 'appointments') ? 'active' : '' ?>sidebar-link waves-effect waves-dark sidebar-link" href="appointments.php"
                                aria-expanded="false">
                                <i class="fa fa-calendar-alt" aria-hidden="true"></i>
                                <span class="hide-menu">Appointment</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="<?php echo ($active == 'eventcalendar') ? 'active' : '' ?>sidebar-link waves-effect waves-dark sidebar-link" href="event-calendar.php"
                                aria-expanded="false">
                                <i class="fa fa-calendar-alt" aria-hidden="true"></i>
                                <span class="hide-menu">Event Calendar</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="<?php echo ($active == 'gallery') ? 'active' : '' ?>sidebar-link waves-effect waves-dark sidebar-link" href="gallery.php"
                                aria-expanded="false">
                                <i class="fa fa-image" aria-hidden="true"></i>
                                <span class="hide-menu">Gallery</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="<?php echo ($active == 'feedback') ? 'active' : '' ?>sidebar-link waves-effect waves-dark sidebar-link" href="feedbacks.php"
                                aria-expanded="false">
                                <i class="fa fa-comment" aria-hidden="true"></i>
                                <span class="hide-menu">Feedbacks</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="<?php echo ($active == 'places') ? 'active' : '' ?>sidebar-link waves-effect waves-dark sidebar-link" href="meeting-places.php"
                                aria-expanded="false">
                                <i class="fa fa-building" aria-hidden="true"></i>
                                <span class="hide-menu">Meeting Places</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="logout.php"
                                aria-expanded="false">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                <span class="hide-menu">Logout</span>
                            </a>
                        </li>
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>