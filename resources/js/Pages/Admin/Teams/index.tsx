import TeamsDataTable from "@/components/Teams/DataTable";
import { buttonVariants } from "@/components/ui/button";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { Link } from "@inertiajs/react";
import { Plus, Search } from "lucide-react";
import { useState } from "react";

interface Team {
    id: number;
    name: string;
    prefix_permissions: string;
}

interface TeamsPageProps {
    teams?: {
        data: Team[];
        links: any;
    };
}

export default function TeamsPage({ teams: serverTeams }: TeamsPageProps) {
    const [search, setSearch] = useState("");

    return (
        <AuthenticatedLayout title="Phòng ban">
            <div className="py-8">
                {/* Header Section */}
                <div className="sm:flex sm:items-center sm:justify-between border-b border-gray-200 pb-8">
                    <div className="">
                        <h1 className="text-2xl font-semibold text-gray-900">
                            Phòng ban
                        </h1>
                        <p className="mt-2 text-sm text-gray-700">
                            Quản lý các phòng ban trong công ty
                        </p>
                    </div>
                    <div className="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-2">
                        <Link
                            href="/admin/users"
                            className={buttonVariants({ variant: "outline" })}
                        >
                            Nhân viên
                        </Link>
                        <Link
                            href="/admin/team/create"
                            className={buttonVariants({ variant: "default" })}
                        >
                            <Plus className="w-4 h-4 mr-2" />
                            Thêm phòng ban
                        </Link>
                    </div>
                </div>

                {/* Search Section */}
                <div className="mt-8">
                    <div className="py-4 border-b border-gray-200">
                        <div className="max-w-lg flex gap-4">
                            <div className="flex-1">
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <Search className="h-5 w-5 text-gray-400" />
                                    </div>
                                    <input
                                        type="text"
                                        value={search}
                                        onChange={(e) =>
                                            setSearch(e.target.value)
                                        }
                                        className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Tìm kiếm phòng ban..."
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Table Section */}
                    <TeamsDataTable />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
