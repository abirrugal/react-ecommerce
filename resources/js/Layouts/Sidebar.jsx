import React, { useState } from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';

const Sidebar = () => {
    let url = history.state?.url ?? '/';
    return (
        <nav className="navbar-vertical navbar">
            <div className="nav-scroller">
                {/* <!-- Brand logo --> */}
                <a className="navbar-brand" href="/">
                    <img src={base_url+'/images/logo/logo.png'} alt="logo" />
                    <span className="text-white">Admin Panel</span>
                </a>
                {/* <!-- Navbar nav --> */}
                <ul className="navbar-nav flex-column" id="sideNavbar">
                    <li className="nav-item">
                        <a className="nav-link has-arrow  active " href="{{ route('admin.dashboard') }}">
                            <i data-feather="home" className="nav-icon icon-xs me-2"></i>  Dashboard
                        </a>
                    </li>

                    {/* <!-- Nav item --> */}

                    <li className="nav-item">
                        <a className="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#categoryMenu" aria-expanded="false" aria-controls="navPages">
                            <i
                                data-feather="layers"
                                className="nav-icon icon-xs me-2">
                            </i> Category
                        </a>
                        <div id="categoryMenu" className="collapse" data-bs-parent="#sideNavbar">
                            <ul className="nav flex-column">
                                <li className="nav-item">
                                    <InertiaLink className="nav-link " href={ base_url+'/admin/category/create'}>
                                        Add Category
                                    </InertiaLink>
                                </li>
                                <li className="nav-item">
                                    <InertiaLink className="nav-link has-arrow" href={base_url+'/admin/category'} >
                                        All Category
                                    </InertiaLink>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    )
}

export default Sidebar