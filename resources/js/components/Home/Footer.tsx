import React from "react";
import { useLaravelReactI18n } from "laravel-react-i18n";

export default function Footer() {
    const currentYear = new Date().getFullYear();
    const { t } = useLaravelReactI18n();

    return (
        <footer className="bg-gray-900 text-white mt-20">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div className="col-span-1 md:col-span-2">
                        <a href="/" className="text-xl font-bold text-white">
                            <img
                                src="/img/logo-modobom-resize.png"
                                alt="Logo modobom"
                            />
                        </a>
                        <p className="mt-4 text-gray-400 text-sm">
                            {t(
                                "Hệ thống quản lý và giám sát nội bộ Modobom, cung cấp các công cụ theo dõi, phân tích và tối ưu hóa hoạt động."
                            )}
                        </p>
                    </div>

                    <div>
                        <h3 className="text-sm font-semibold text-gray-400 uppercase tracking-wider">
                            {t("Hệ thống")}
                        </h3>
                        <ul className="mt-4 space-y-3">
                            <FooterLink href="#" text={t("Bảng điều khiển")} />
                            <FooterLink href="#" text={t("Cấu hình")} />
                            <FooterLink href="#" text={t("Giám sát")} />
                        </ul>
                    </div>

                    <div>
                        <h3 className="text-sm font-semibold text-gray-400 uppercase tracking-wider">
                            {t("Hỗ trợ")}
                        </h3>
                        <ul className="mt-4 space-y-3">
                            <FooterLink href="#" text={t("Tài liệu")} />
                            <FooterLink href="#" text={t("Hướng dẫn")} />
                            <FooterLink href="#" text={t("Liên hệ")} />
                        </ul>
                    </div>
                </div>

                <div className="mt-12 pt-8 border-t border-gray-800">
                    <div className="flex flex-col md:flex-row justify-between items-center">
                        <div className="flex space-x-6">
                            <FooterLink
                                href="#"
                                text={t("Điều khoản nội bộ")}
                                className="text-gray-400 hover:text-gray-300 text-sm"
                            />
                            <FooterLink
                                href="#"
                                text={t("Chính sách bảo mật")}
                                className="text-gray-400 hover:text-gray-300 text-sm"
                            />
                        </div>
                        <div className="mt-4 md:mt-0">
                            <p className="text-gray-400 text-sm">
                                &copy; {currentYear} Modobom
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    );
}

interface FooterLinkProps {
    href: string;
    text: string;
    className?: string;
}

const FooterLink = ({
    href,
    text,
    className = "text-gray-300 hover:text-white text-sm transition-colors list-none",
}: FooterLinkProps) => (
    <li className="list-none">
        <a href={href} className={className}>
            {text}
        </a>
    </li>
);
