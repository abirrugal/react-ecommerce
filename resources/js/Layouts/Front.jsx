import React, { useState } from 'react';
import Sidebar from './Sidebar';
import NavBar from './NavBar';

const Front = ({ title, children }) => {

    const [isSidebarCollapsed, setIsSidebarCollapsed] = useState(false);
    const toggleSidebar = () => {
        setIsSidebarCollapsed(!isSidebarCollapsed);
    };

    React.useEffect(() => {
        document.title = title;
    })
    return (
        <React.Fragment>
            <div id="db-wrapper" className={`sidebar ${isSidebarCollapsed ? 'toggled' : ''}`}>
                <Sidebar />
                <div id="page-content">
                    <NavBar onToggleSidebar={toggleSidebar} />
                    <div className="container-fluid">
                        {children}
                    </div>
                </div>
            </div>
        </React.Fragment>
    )
}

export default Front