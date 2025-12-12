import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import './InventoryLayout.css';

export default function InventoryLayout({ children, title }) {
    const { auth } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(true);

    const isAdmin = auth.user.role === 'admin';

    return (
        <div className="inventory-layout">
            {/* Rainbow Header */}
            <header className="rainbow-header">
                <div className="header-content">
                    <div className="header-left">
                        <button 
                            className="menu-toggle"
                            onClick={() => setSidebarOpen(!sidebarOpen)}
                        >
                            ☰
                        </button>
                        <h1>🌈 Rainbow Direct Selling Inventory</h1>
                    </div>
                    <div className="header-right">
                        <span className="user-info">
                            {auth.user.name} ({auth.user.role})
                        </span>
                        <Link href="/profile" className="header-link">
                            Profile
                        </Link>
                        <Link 
                            href="/logout" 
                            method="post" 
                            as="button"
                            className="logout-btn"
                        >
                            Sign Out
                        </Link>
                    </div>
                </div>
            </header>

            {/* Main Layout */}
            <div className="layout-wrapper">
                {/* Sidebar Navigation */}
                {sidebarOpen && (
                    <aside className="sidebar">
                        <nav className="nav-menu">
                            <Link 
                                href="/dashboard" 
                                className="nav-item"
                            >
                                📊 Dashboard
                            </Link>
                            
                            <Link 
                                href="/products" 
                                className="nav-item"
                            >
                                📦 Products
                            </Link>

                            <Link 
                                href="/sales" 
                                className="nav-item"
                            >
                                💰 Sales
                            </Link>

                            {isAdmin && (
                                <>
                                    <div className="nav-divider">ADMIN ONLY</div>
                                    
                                    <Link 
                                        href="/categories" 
                                        className="nav-item"
                                    >
                                        🏷️ Categories
                                    </Link>

                                    <Link 
                                        href="/activity-logs" 
                                        className="nav-item"
                                    >
                                        📋 Activity Logs
                                    </Link>
                                </>
                            )}
                        </nav>
                    </aside>
                )}

                {/* Main Content */}
                <main className="main-content">
                    {title && <h2 className="page-title">{title}</h2>}
                    {children}
                </main>
            </div>
        </div>
    );
}
