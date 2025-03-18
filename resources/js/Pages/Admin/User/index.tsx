import { SearchInput } from "@/components/Inputs/SearchInput";
import { buttonVariants } from "@/components/ui/button";
import UserDataTable from "@/components/Users/DataTable";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { Link } from "@inertiajs/react";
import { PlusIcon } from "lucide-react";
import React, { useState } from "react";

interface User {
    id: number;
    name: string;
    email: string;
}

interface UsersPageProps {
    users: {
        data: User[];
        links: any; // For pagination
    };
}

export default function UsersPage({ users }: UsersPageProps) {
    const [search, setSearch] = useState("");

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        // Implement search functionality
    };

    return (
        <AuthenticatedLayout title="Users">
            <div className="py-8">
                {/* Header Section */}
                <div className="sm:flex sm:items-center sm:justify-between border-border border-b pb-6">
                    <div>
                        <h1 className="text-2xl font-semibold text-gray-900">
                            Nhân viên
                        </h1>
                        <p className="mt-2 text-sm text-gray-700">
                            Quản lý nhân viên và quyền của họ
                        </p>
                    </div>
                    <div className="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-2">
                        <Link
                            href="/admin/team"
                            className={buttonVariants({ variant: "outline" })}
                        >
                            Phòng ban
                        </Link>
                        <Link
                            href="/admin/users/create"
                            className={buttonVariants({ variant: "default" })}
                        >
                            <PlusIcon className="w-4 h-4 mr-2" />
                            Thêm nhân viên
                        </Link>
                    </div>
                </div>

                {/* Search Section */}
                <div className="mt-8">
                    <div className="py-4">
                        <form
                            onSubmit={handleSearch}
                            className="max-w-lg flex gap-4"
                        >
                            <SearchInput
                                value={search}
                                className="w-96"
                                onChange={(e) => setSearch(e.target.value)}
                                placeholder="Tìm kiếm nhân viên..."
                            />
                        </form>
                    </div>
                </div>

                {/* Table Section */}
                <UserDataTable />
            </div>
        </AuthenticatedLayout>
    );
}
