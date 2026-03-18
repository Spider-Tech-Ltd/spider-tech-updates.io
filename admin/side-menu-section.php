         <div class="sidebar-container">
				<div class="sidemenu-container navbar-collapse collapse fixed-menu">
					<div id="remove-scroll" class="left-sidemenu">
						<ul class="sidemenu  page-header-fixed slimscroll-style" data-keep-expanded="false"
							data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
							<li class="sidebar-toggler-wrapper hide">
								<div class="sidebar-toggler">
									<span></span>
								</div>
							</li>
							<li class="sidebar-user-panel">
								<div class="user-panel">
									<div class="pull-left image">
									
									<img alt="" class="img-circle " src="../images/icon/testimonials_homepage.png" />
									</div>
									<div class="pull-left info">
										<p> Super Admin<?php /*if(isset($_SESSION['sname'])) {echo $_SESSION['sname'];}*/ ?></p>
										<a href="#"><i class="fa fa-circle user-online"></i><span class="txtOnline">
												Online</span></a>
									</div>
								</div>
							</li>
							<li class="nav-item start active open">
								<a href="dashboard.php" class="nav-link nav-toggle">
									<i class="material-icons">dashboard</i>
									<span class="title">Dashboard</span>
									<span class="selected"></span>
									<span class="arrow open"></span>
								</a>
							</li>
							<li class="nav-item start">
								<a href="spidertech.com.ng/webmail.php" target="_blank" class="nav-link nav-toggle">
									<i class="material-icons">email</i>
									<span class="title">Webmail</span>
								</a>
							</li>
							<!--
                            <li class="nav-item">
								<a href="#" class="nav-link nav-toggle"> <i class="material-icons">people</i>
									<span class="title">Team Members</span> <span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item">
										<a href="all_members.php" class="nav-link "> <span class="title">All
												Team Members</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="add_members.php" class="nav-link "> <span class="title">New Team Member</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="all_members.php" class="nav-link "> <span class="title">Edit
												Team Member</span>
										</a>
									</li>
									
									<li class="nav-item">
										<a href="#" class="nav-link "> <span class="title">Member
												Profile</span>
										</a>
									</li>
									
								</ul>
							</li>
							-->
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle"> <i
										class="material-icons">info</i>
									<span class="title">About Page</span> <span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item">
										<a href="#" class="nav-link nav-toggle"> <i
                                                class="fa fa-history"></i>
                                            <span class="title">About Us</span> <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
										<li class="nav-item">
                                                <a href="all_about_info.php" class="nav-link "> <span class="title">All</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="add_about_information.php" class="nav-link "> <span class="title">Add
                                                        New</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="edit_about_information.php" class="nav-link "> <span class="title">Update</span>
                                                </a>
                                            </li>
                                        </ul>
									</li>
                                    <li class="nav-item">
										<a href="#" class="nav-link nav-toggle"> <i
                                                class="fa fa-eye"></i>
                                            <span class="title">Mission Statement</span> <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="add_mission_statement.php" class="nav-link "> <span class="title">Add
                                                        Mission</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="edit_mission_statement.php" class="nav-link "> <span class="title">Edit
                                                        Mission</span>
                                                </a>
                                            </li>
                                        </ul>
									</li>
                                    <li class="nav-item">
										<a href="#" class="nav-link nav-toggle"> <i
                                                class="fa fa-eye"></i>
                                            <span class="title">Vision Statement</span> <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="add_vision_statement.php" class="nav-link "> <span class="title">Add
                                                        Vision</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="edit_vision_statement.php" class="nav-link "> <span class="title">Edit
                                                        Vision</span>
                                                </a>
                                            </li>
                                        </ul>
									</li>
                                    <li class="nav-item">
										<a href="#" class="nav-link nav-toggle"> <i
                                                class="fa fa-key"></i>
                                            <span class="title">Core Values</span> <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="add_core_value.php" class="nav-link "> <span class="title">Add
                                                        Value</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="edit_core_value.php" class="nav-link "> <span class="title">Edit
                                                        Value</span>
                                                </a>
                                            </li>
                                        </ul>
									</li>
									<!--
                                    <li class="nav-item">
										<a href="#" class="nav-link nav-toggle"> <i
                                                class="fa fa-users"></i>
                                            <span class="title">Leadership</span> <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="add_organisation_structure.php" class="nav-link "> <span class="title">Add
                                                        Leadership</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="edit_organisation_structure.php" class="nav-link "> <span class="title">Edit
                                                        Leadership</span>
                                                </a>
                                            </li>
                                        </ul>
									</li>
                                    
									<li class="nav-item">
										<a href="#" class="nav-link nav-toggle"> <i
                                                class="fa fa-star"></i>
                                            <span class="title">Ranking</span> <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="add_ranking_awards.php" class="nav-link "> <span class="title">Add
                                                        Ranking</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="edit_ranking_awards.php" class="nav-link "> <span class="title">Edit
                                                        Ranking</span>
                                                </a>
                                            </li>
                                        </ul>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link nav-toggle"> <i
                                                class="fa fa-star"></i>
                                            <span class="title">Awards</span> <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="add_awards.php" class="nav-link "> <span class="title">Add
                                                         Award</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="edit_awards.php" class="nav-link "> <span class="title">Edit
                                                         Award</span>
                                                </a>
                                            </li>
                                        </ul>
									</li>
									-->
								</ul>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle"> <i
										class="material-icons">place</i>
									<span class="title">Contact Details</span> <span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item">
										<a href="add_contact_details.php" class="nav-link "> <span class="title">Add
												Contact Details</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="edit_contact_details.php" class="nav-link "> <span class="title">Edit
												Contact Details</span>
										</a>
									</li>
								</ul>
							</li>
							<!--
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle"> <i
										class="material-icons">question_answer</i>
									<span class="title">FAQ</span> <span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item">
										<a href="all_faq.php" class="nav-link "> <span class="title">All
												FAQ</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="add_faq.php" class="nav-link "> <span class="title">Add
												FAQ</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="all_faq.php" class="nav-link "> <span class="title">Edit
												FAQ</span>
										</a>
									</li>
								</ul>
							</li>
							
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle"> <i
										class="material-icons">toc</i>
									<span class="title">Subsidiary</span> <span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item">
										<a href="all_subsidiary.php" class="nav-link "> <span class="title">All
											Subsidiary</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="add_subsidiary.php" class="nav-link "> <span class="title">Add
												Subsidiary</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="all_subsidiary.php" class="nav-link "> <span class="title">Edit
												Ssubsidiary</span>
										</a>
									</li>
								</ul>
							</li>
							-->
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle"> <i
										class="material-icons">question_answer</i>
									<span class="title">Services</span> <span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item">
										<a href="all_services.php" class="nav-link "> <span class="title">All
												Services</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="add_services.php" class="nav-link "> <span class="title">Add
												Services</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="all_services.php" class="nav-link "> <span class="title">Edit
												Services</span>
										</a>
									</li>
								</ul>
							</li>
							<!--
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle"> <i
										class="material-icons">email</i>
									<span class="title">Enquiries</span> <span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item">
										<a href="all_enquiries.php" class="nav-link "> <span class="title">All
												Inbox</span>
										</a>
									</li>
									
									<li class="nav-item">
										<a href="compose_message.php" class="nav-link "> <span class="title">Edit
												Compose Message</span>
										</a>
									</li>
								</ul>
							</li>
							-->
						</ul>
					</div>
				</div>
			</div>