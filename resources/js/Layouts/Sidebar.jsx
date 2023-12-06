import React, { useState } from 'react';
// import { Link } from '@inertiajs/inertia-react';
import { Link } from '@inertiajs/react'

const Sidebar = () => {
    let url = history.state?.url ?? '/';
    const homeIcon = <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="feather feather-home nav-icon icon-xs me-2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>;
    const menuIcon = <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="feather feather-layers nav-icon icon-xs me-2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>;
    return (
        <nav className="navbar-vertical navbar">
            <div className="nav-scroller">
                {/* <!-- Brand logo --> */}
                <a className="navbar-brand" href="/">
                    <img src={base_url + '/images/logo/logo.png'} className='mr-2' alt="logo" />
                    <span className="text-white">Admin Panel</span>
                </a>
                {/* <!-- Navbar nav --> */}
                <ul className="navbar-nav flex-column" id="sideNavbar">
                    <li className="nav-item">
                        <Link className="nav-link has-arrow  active " href={base_url + '/'}>
                            {homeIcon} Dashboard
                        </Link>
                    </li>

                    {/* <!-- Nav item --> */}

                    {/* Categories  */}

                    <li className="nav-item">
                        <a className="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#categoryMenu" aria-expanded="false" aria-controls="navPages">
                            {menuIcon} Category
                        </a>
                        <div id="categoryMenu" className="collapse" data-bs-parent="#sideNavbar">
                            <ul className="nav flex-column">
                                <li className="nav-item">
                                    <Link className="nav-link " href={base_url + '/admin/category/create'}>
                                        Add Category
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link has-arrow" href={base_url + '/admin/category'} >
                                        All Category
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {/* SubCategory  */}

                    <li className="nav-item">
                        <a className="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#subCategoryMenu" aria-expanded="false" aria-controls="navPages">
                            {menuIcon}Sub Category
                        </a>
                        <div id="subCategoryMenu" className="collapse" data-bs-parent="#sideNavbar">
                            <ul className="nav flex-column">
                                <li className="nav-item">
                                    <Link className="nav-link " href={base_url + '/admin/subcategory/create'}>
                                        Add Sub Category
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link has-arrow" href={base_url + '/admin/subcategory'} >
                                        All Sub Category
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {/* Brand  */}

                    <li className="nav-item">
                        <a className="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#brandMenu" aria-expanded="false" aria-controls="navPages">
                            {menuIcon}Brand
                        </a>
                        <div id="brandMenu" className="collapse" data-bs-parent="#sideNavbar">
                            <ul className="nav flex-column">
                                <li className="nav-item">
                                    <Link className="nav-link " href={base_url + '/admin/brand/create'}>
                                        Add Brand
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link has-arrow" href={base_url + '/admin/brand'} >
                                        All Brand
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {/* Users  */}

                    <li className="nav-item">
                        <a className="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#userMenu" aria-expanded="false" aria-controls="navPages">
                            {menuIcon}Users
                        </a>
                        <div id="userMenu" className="collapse" data-bs-parent="#sideNavbar">
                            <ul className="nav flex-column">
                                <li className="nav-item">
                                    <Link className="nav-link has-arrow" href={base_url + '/admin/users'} >
                                        All Users
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {/* Product  */}

                    <li className="nav-item">
                        <a className="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#productMenu" aria-expanded="false" aria-controls="navPages">
                            {menuIcon}Product
                        </a>
                        <div id="productMenu" className="collapse" data-bs-parent="#sideNavbar">
                            <ul className="nav flex-column">
                                <li className="nav-item">
                                    <Link className="nav-link has-arrow" href={base_url + '/admin/product'} >
                                        Add Product
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </li>

                
                    {/* Product Variant  */}

                    <li className="nav-item">
                        <a className="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#variantMenu" aria-expanded="false" aria-controls="navPages">
                            {menuIcon} Product Variants
                        </a>
                        <div id="variantMenu" className="collapse" data-bs-parent="#sideNavbar">
                            <ul className="nav flex-column">
                                <li className="nav-item">
                                    <Link className="nav-link " href={base_url + '/admin/attribute/create'}>
                                        Add Variant
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link has-arrow" href={base_url + '/admin/attribute'} >
                                        Variant List
                                    </Link>
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