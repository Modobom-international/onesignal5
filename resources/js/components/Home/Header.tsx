import React, { useState, useEffect } from "react";

export default function Header() {
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [showShadow, setShowShadow] = useState(false);
    const [systemMenuOpen, setSystemMenuOpen] = useState(false);

    // Handle scroll effect
    useEffect(() => {
        const handleScroll = () => {
            setShowShadow(window.scrollY > 0);
        };
        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, []);

    return (
        <header
            className={`fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-sm border-b border-gray-200 ${
                showShadow ? "shadow-sm" : ""
            }`}
        >
            <div className="relative">
                <nav className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-16">
                        {/* Logo */}
                        <div className="flex-shrink-0 flex items-center">
                            <a href="/" className="flex items-center space-x-2">
                                <div className="flex lg:justify-center lg:col-start-2">
                                    <img
                                        src="/img/logo-modobom-resize-dark.png"
                                        alt="Logo modobom"
                                    />
                                </div>
                            </a>
                        </div>

                        {/* Navigation Links - Desktop */}
                        <div className="hidden lg:flex lg:items-center lg:space-x-8">
                            {/* System Menu */}
                            <div
                                className="nav-item relative"
                                onMouseEnter={() => setSystemMenuOpen(true)}
                                onMouseLeave={() => setSystemMenuOpen(false)}
                            >
                                <button className="group inline-flex items-center text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors">
                                    Hệ thống
                                    <svg
                                        className={`ml-1.5 h-4 w-4 transition-transform duration-200 ${
                                            systemMenuOpen ? "rotate-180" : ""
                                        }`}
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M19 9l-7 7-7-7"
                                        />
                                    </svg>
                                </button>

                                {systemMenuOpen && (
                                    <div
                                        className="nav-dropdown absolute -ml-4 mt-0 w-screen max-w-md transform px-2"
                                        style={{
                                            perspective: "2000px",
                                            transform: "rotateX(-15deg)",
                                        }}
                                    >
                                        <div className="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                            <div className="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                                {/* System Menu Items */}
                                                <SystemMenuItem
                                                    title="Bảng điều khiển"
                                                    description="Theo dõi hoạt động hệ thống"
                                                    icon={<ChartIcon />}
                                                />
                                                <SystemMenuItem
                                                    title="Cấu hình"
                                                    description="Quản lý cài đặt hệ thống"
                                                    icon={<SettingsIcon />}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </div>

                            <NavLink href="#" text="Giám sát" />
                            <NavLink href="#" text="Nhật ký" />
                            <NavLink href="#" text="Hỗ trợ" />
                        </div>

                        {/* Right Navigation */}
                        <div className="hidden lg:flex lg:items-center lg:space-x-6">
                            <a
                                href="/login"
                                className="group inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 shadow-sm hover:shadow"
                            >
                                Truy cập hệ thống
                                <svg
                                    className="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>
                        </div>

                        {/* Mobile menu button */}
                        <div className="flex items-center lg:hidden">
                            <button
                                onClick={() =>
                                    setMobileMenuOpen(!mobileMenuOpen)
                                }
                                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 transition-colors"
                            >
                                <span className="sr-only">Open main menu</span>
                                {!mobileMenuOpen ? <MenuIcon /> : <CloseIcon />}
                            </button>
                        </div>
                    </div>
                </nav>

                {/* Mobile menu */}
                {mobileMenuOpen && (
                    <div className="lg:hidden absolute inset-x-0 transform shadow-lg bg-white border-b border-gray-200">
                        <div className="pt-2 pb-3 space-y-1">
                            <MobileNavLink href="#" text="Hệ thống" />
                            <MobileNavLink href="#" text="Giám sát" />
                            <MobileNavLink href="#" text="Nhật ký" />
                            <MobileNavLink href="#" text="Hỗ trợ" />
                        </div>
                        <div className="pt-4 pb-3 border-t border-gray-200">
                            <div className="space-y-1">
                                <MobileNavLink href="/login" text="Đăng nhập" />
                                <MobileNavLink
                                    href="#"
                                    text="Truy cập hệ thống"
                                    isPurple
                                />
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </header>
    );
}

// Helper Components
const NavLink = ({ href, text }: { href: string; text: string }) => (
    <a
        href={href}
        className="relative nav-link-active text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors"
    >
        {text}
    </a>
);

const MobileNavLink = ({
    href,
    text,
    isPurple,
}: {
    href: string;
    text: string;
    isPurple?: boolean;
}) => (
    <a
        href={href}
        className={`block px-4 py-2 text-base font-medium ${
            isPurple
                ? "text-purple-600 hover:text-purple-700"
                : "text-gray-500 hover:text-gray-900"
        } hover:bg-gray-50`}
    >
        {text}
    </a>
);

const SystemMenuItem = ({
    title,
    description,
    icon,
}: {
    title: string;
    description: string;
    icon: React.ReactNode;
}) => (
    <a
        href="#"
        className="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50 transition ease-in-out duration-150"
    >
        <div className="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-purple-600 text-white sm:h-12 sm:w-12">
            {icon}
        </div>
        <div className="ml-4">
            <p className="text-base font-medium text-gray-900">{title}</p>
            <p className="mt-1 text-sm text-gray-500">{description}</p>
        </div>
    </a>
);

// Icons
const MenuIcon = () => (
    <svg
        className="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth="2"
            d="M4 6h16M4 12h16M4 18h16"
        />
    </svg>
);

const CloseIcon = () => (
    <svg
        className="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth="2"
            d="M6 18L18 6M6 6l12 12"
        />
    </svg>
);

const ChartIcon = () => (
    <svg
        className="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth="2"
            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
        />
    </svg>
);

const SettingsIcon = () => (
    <svg
        className="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth="2"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
        />
        <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
        />
    </svg>
);
