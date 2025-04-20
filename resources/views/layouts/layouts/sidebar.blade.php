<div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
							<li class="submenu">
								<a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a class="active" href="/dashboard">Admin Dashboard</a></li>
								</ul>
							</li>
							
							<li class="menu-title"> 
								<span>Concession Management</span>
							</li>
							<li>
								<a href="{{ route('concession.add') }}"><i class="la la-files-o"></i> <span> Add Concessions </span></a>
							</li>
							
							<li class="menu-title"> 
								<span>Order Management</span>
							</li>
							<li>
								<a href="{{ route('order.add') }}"><i class="la la-shopping-cart"></i>
								<span> Create An Order </span></a>
							</li>
							<li>
								<a href="{{ route('order.manage') }}"><i class="la la-tasks"></i>
								<span>Manage Order </span></a>
							</li>
							<li class="menu-title"> 
								<span>Kitchen Management</span>
							</li>
							<li>
								<a href="{{ route('kitchen.index') }}"><i class="la la-utensils me-2"></i>
								<span>Kitchen Management </span></a>
							</li>
						</ul>
					</div>
                </div>
            </div>