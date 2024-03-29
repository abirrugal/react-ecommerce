import React, { useState } from 'react';
import { Link } from '@inertiajs/react'

const NavBar = ({onToggleSidebar}) => {


return (
<div className="header @@classList">
    {/* <!-- navbar --> */}
    <nav className="navbar-classic navbar navbar-expand-lg">
        <a id="nav-toggle" href="#" onClick={onToggleSidebar}><i
            data-feather="menu"
            className="nav-icon me-2 icon-xs"></i><i className="fa fa-bars" aria-hidden="true"></i></a>

        {/* <div className="ms-lg-3 d-none d-md-none d-lg-block">
            <form className="d-flex align-items-center">
                <input type="search" className="form-control" placeholder="Search" />
            </form>
        </div> */}
        {/* <!--Navbar nav --> */}
        <ul className="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
            <li className="dropdown stopevent">
                <a className="btn btn-light btn-icon rounded-circle indicator
                    indicator-primary text-muted" href="#" role="button"
                    id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                <i className="icon-xs" data-feather="bell"></i>
                </a>
                <div className="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                    aria-labelledby="dropdownNotification">
                    <div>
                        <div className="border-bottom px-3 pt-2 pb-3 d-flex
                            justify-content-between align-items-center">
                            <p className="mb-0 text-dark fw-medium fs-4">Notifications</p>
                            <a href="#" className="text-muted">
                            <span>
                            <i className="me-1 icon-xxs" data-feather="settings"></i>
                            </span>
                            </a>
                        </div>
                        {/* <!-- List group --> */}
                        <ul className="list-group list-group-flush notification-list-scroll">
                            {/* <!-- List group item --> */}
                            <li className="list-group-item bg-light">
                                <a href="#" className="text-muted">
                                    <h5 className=" mb-1">Rishi Chopra</h5>
                                    <p className="mb-0">
                                        Mauris blandit erat id nunc blandit, ac eleifend dolor pretium.
                                    </p>
                                </a>
                            </li>
                            {/* <!-- List group item --> */}
                            <li className="list-group-item">
                                <a href="#" className="text-muted">
                                    <h5 className=" mb-1">Neha Kannned</h5>
                                    <p className="mb-0">
                                        Proin at elit vel est condimentum elementum id in ante. Maecenas et sapien metus.
                                    </p>
                                </a>
                            </li>
                            {/* <!-- List group item --> */}
                            <li className="list-group-item">
                                <a href="#" className="text-muted">
                                    <h5 className=" mb-1">Nirmala Chauhan</h5>
                                    <p className="mb-0">
                                        Morbi maximus urna lobortis elit sollicitudin sollicitudieget elit vel pretium.
                                    </p>
                                </a>
                            </li>
                            {/* <!-- List group item --> */}
                            <li className="list-group-item">
                                <a href="#" className="text-muted">
                                    <h5 className=" mb-1">Sina Ray</h5>
                                    <p className="mb-0">
                                        Sed aliquam augue sit amet mauris volutpat hendrerit sed nunc eu diam.
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <div className="border-top px-3 py-2 text-center">
                            <a href="#" className="text-inherit fw-semi-bold">
                            View all Notifications
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            {/* <!-- List --> */}
            <li className="dropdown ms-2">
                <a className="rounded-circle" href="#" role="button" id="dropdownUser"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div className="avatar avatar-md avatar-indicators avatar-online">
                        <img alt="avatar" src={base_url+"/theme/dashboard/assets/images/avatar/avatar-1.jpg"}
                            className="rounded-circle" />
                    </div>
                </a>
                <div className="dropdown-menu dropdown-menu-end"
                    aria-labelledby="dropdownUser">
                    <div className="px-4 pb-0 pt-2">
                        <div className="lh-1 ">
                            <h5 className="mb-1"> John E. Grainger</h5>
                            <a href="#" className="text-inherit fs-6">View my profile</a>
                        </div>
                        <div className=" dropdown-divider mt-3 mb-2"></div>
                    </div>
                    <ul className="list-unstyled">
                        <li>
                            <a className="dropdown-item" href="#">
                            <i className="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Edit
                            Profile
                            </a>
                        </li>
                        <li>
                            <a className="dropdown-item"
                                href="#">
                            <i className="me-2 icon-xxs dropdown-item-icon"
                                data-feather="activity"></i>Activity Log
                            </a>
                        </li>

                        <li>
                            <a className="dropdown-item" href="#">
                            <i className="me-2 icon-xxs dropdown-item-icon"
                                data-feather="settings"></i>Account Settings
                            </a>
                        </li>
                        <li>
                            <a className="dropdown-item" href="{{ route('logout') }}">
                            <i className="me-2 icon-xxs dropdown-item-icon"
                                data-feather="power"></i>Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</div>
    )
}

export default NavBar