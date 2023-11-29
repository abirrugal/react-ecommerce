import React, { useState } from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';

const Sidebar = () => {
    let url = history.state?.url ?? '/';
    return (
        <nav className="navbar-vertical navbar">
            <div className="nav-scroller">
                {/* <!-- Brand logo --> */}
                <a className="navbar-brand" href="/">
                    <img src={base_url+'/images/logo/logo.png'} className='mr-2' alt="logo" />
                    <span className="text-white">Admin Panel</span>
                </a>
                {/* <!-- Navbar nav --> */}
                <ul className="navbar-nav flex-column" id="sideNavbar">
                    <li className="nav-item">
                        <a className="nav-link has-arrow  active " href="{{ route('admin.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home nav-icon icon-xs me-2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>  Dashboard
                        </a>
                    </li>

                    {/* <!-- Nav item --> */}

                    <li className="nav-item">
                        <a className="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#categoryMenu" aria-expanded="false" aria-controls="navPages">
                        

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers nav-icon icon-xs me-2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                            Category
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