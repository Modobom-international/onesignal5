import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";

import { useForm } from "@inertiajs/react";
import {
    ArrowLeft,
    ChevronDown,
    ChevronRight,
    ChevronUp,
    Home,
} from "lucide-react";
import { useState } from "react";

interface Team {
    id: number;
    name: string;
    permissions?: string[];
}

interface PermissionRoute {
    id: number;
    name: string;
    prefix: string;
}

interface Permission {
    [key: string]: PermissionRoute[];
}

export default function CreatUserPage() {
    const { data, setData, post, processing, errors } = useForm({
        name: "",
        email: "",
        password: "",
        address: "",
        phone_number: "",
        team: "",
        permissions: {} as { [key: string]: boolean },
    });

    const [teams, setTeams] = useState<Team[]>([
        { id: 1, name: "Development Team" },
        { id: 2, name: "Marketing Team" },
        { id: 3, name: "Sales Team" },
    ]);

    const [permissions, setPermissions] = useState<Permission>({
        "push-system": [
            { id: 1, name: "push.view", prefix: "push" },
            { id: 2, name: "push.create", prefix: "push" },
            { id: 3, name: "push.edit", prefix: "push" },
            { id: 4, name: "push.delete", prefix: "push" },
        ],
        "log-behavior": [
            { id: 5, name: "log.view", prefix: "log" },
            { id: 6, name: "log.export", prefix: "log" },
            { id: 7, name: "log.delete", prefix: "log" },
        ],
        users: [
            { id: 8, name: "users.view", prefix: "users" },
            { id: 9, name: "users.create", prefix: "users" },
            { id: 10, name: "users.edit", prefix: "users" },
            { id: 11, name: "users.delete", prefix: "users" },
        ],
        domain: [
            { id: 12, name: "domain.view", prefix: "domain" },
            { id: 13, name: "domain.create", prefix: "domain" },
            { id: 14, name: "domain.edit", prefix: "domain" },
            { id: 15, name: "domain.delete", prefix: "domain" },
        ],
        "html-source": [
            { id: 16, name: "html.view", prefix: "html" },
            { id: 17, name: "html.create", prefix: "html" },
            { id: 18, name: "html.edit", prefix: "html" },
            { id: 19, name: "html.delete", prefix: "html" },
        ],
        "users-tracking": [
            { id: 20, name: "tracking.view", prefix: "tracking" },
            { id: 21, name: "tracking.export", prefix: "tracking" },
            { id: 22, name: "tracking.delete", prefix: "tracking" },
        ],
        team: [
            { id: 23, name: "team.view", prefix: "team" },
            { id: 24, name: "team.create", prefix: "team" },
            { id: 25, name: "team.edit", prefix: "team" },
            { id: 26, name: "team.delete", prefix: "team" },
        ],
    });

    const [openSections, setOpenSections] = useState<{
        [key: string]: boolean;
    }>({
        "push-system": false,
        "log-behavior": false,
        users: false,
        domain: false,
        "html-source": false,
        "users-tracking": false,
        team: false,
    });

    return (
        <AuthenticatedLayout title="Thêm nhân viên">
            <div>
                <div className="mb-8 border-b border-border pb-6">
                    {/* Breadcrumbs */}
                    <div className="flex items-center text-sm text-muted-foreground mb-4">
                        <Home className="w-4 h-4" />
                        <ChevronRight className="w-4 h-4 mx-2" />
                        <span>Quản lý nhân viên</span>
                        <ChevronRight className="w-4 h-4 mx-2" />
                        <span>Thêm nhân viên</span>
                    </div>

                    {/* Welcome Message */}
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-3xl font-bold tracking-tight">
                                Thêm nhân viên
                            </h1>
                            <p className="text-muted-foreground mt-1">
                                Thêm nhân viên mới vào hệ thống và phân quyền
                                truy cập
                            </p>
                        </div>

                        <Button
                            variant="outline"
                            onClick={() =>
                                (window.location.href = "/admin/users")
                            }
                            className="flex items-center space-x-2 hover:bg-gray-50"
                        >
                            <ArrowLeft className="h-4 w-4" />
                            <span>Quay lại danh sách</span>
                        </Button>
                    </div>
                </div>

                <form className="">
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* Left Column - User Information */}
                        <div className="lg:col-span-2 space-y-6">
                            <div className="bg-white rounded-lg">
                                <div className="flex items-center justify-between mb-6">
                                    <div>
                                        <h2 className="font-medium text-gray-800">
                                            Thông tin cá nhân
                                        </h2>
                                        <p className="text-xs text-gray-500">
                                            Nhập thông tin cơ bản của nhân viên
                                        </p>
                                    </div>
                                </div>

                                <div className="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {/* Name Field */}
                                    <div className="space-y-1.5">
                                        <Label
                                            htmlFor="name"
                                            className="block text-sm font-medium text-gray-700"
                                        >
                                            Tên
                                        </Label>
                                        <Input
                                            type="text"
                                            id="name"
                                            name="name"
                                            value={data.name}
                                            onChange={(e) =>
                                                setData("name", e.target.value)
                                            }
                                            disabled={processing}
                                            placeholder="Nhập tên nhân viên"
                                            className="w-full"
                                        />
                                        {errors.name && (
                                            <p className="text-sm text-red-500">
                                                {errors.name}
                                            </p>
                                        )}
                                    </div>

                                    {/* Email Field */}
                                    <div className="space-y-1.5">
                                        <Label
                                            htmlFor="email"
                                            className="block text-sm font-medium text-gray-700"
                                        >
                                            Hòm thư
                                        </Label>
                                        <Input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value={data.email}
                                            onChange={(e) =>
                                                setData("email", e.target.value)
                                            }
                                            disabled={processing}
                                            placeholder="example@company.com"
                                            className="w-full"
                                        />
                                        {errors.email && (
                                            <p className="text-sm text-red-500">
                                                {errors.email}
                                            </p>
                                        )}
                                    </div>

                                    {/* Password Field */}
                                    <div className="space-y-1.5">
                                        <Label
                                            htmlFor="password"
                                            className="block text-sm font-medium text-gray-700"
                                        >
                                            Mật khẩu
                                        </Label>
                                        <Input
                                            type="password"
                                            id="password"
                                            name="password"
                                            value={data.password}
                                            onChange={(e) =>
                                                setData(
                                                    "password",
                                                    e.target.value
                                                )
                                            }
                                            disabled={processing}
                                            placeholder="••••••••"
                                            className="w-full"
                                        />
                                        {errors.password && (
                                            <p className="text-sm text-red-500">
                                                {errors.password}
                                            </p>
                                        )}
                                    </div>

                                    {/* Phone Number Field */}
                                    <div className="space-y-1.5">
                                        <Label
                                            htmlFor="phone_number"
                                            className="block text-sm font-medium text-gray-700"
                                        >
                                            Số điện thoại
                                        </Label>
                                        <Input
                                            type="text"
                                            id="phone_number"
                                            name="phone_number"
                                            value={data.phone_number}
                                            onChange={(e) =>
                                                setData(
                                                    "phone_number",
                                                    e.target.value
                                                )
                                            }
                                            disabled={processing}
                                            placeholder="Nhập số điện thoại"
                                            className="w-full"
                                        />
                                        {errors.phone_number && (
                                            <p className="text-sm text-red-500">
                                                {errors.phone_number}
                                            </p>
                                        )}
                                    </div>

                                    {/* Address Field - Full Width */}
                                    <div className="space-y-1.5 md:col-span-2">
                                        <Label
                                            htmlFor="address"
                                            className="block text-sm font-medium text-gray-700"
                                        >
                                            Địa chỉ
                                        </Label>
                                        <Input
                                            type="text"
                                            id="address"
                                            name="address"
                                            value={data.address}
                                            onChange={(e) =>
                                                setData(
                                                    "address",
                                                    e.target.value
                                                )
                                            }
                                            disabled={processing}
                                            placeholder="Nhập địa chỉ"
                                            className="w-full"
                                        />
                                        {errors.address && (
                                            <p className="text-sm text-red-500">
                                                {errors.address}
                                            </p>
                                        )}
                                    </div>

                                    {/* Team Selection - Full Width */}
                                    <div className="space-y-1.5 md:col-span-2">
                                        <Label
                                            htmlFor="team"
                                            className="block text-sm font-medium text-gray-700"
                                        >
                                            Phòng ban
                                        </Label>
                                        <Select
                                            value={data.team}
                                            onValueChange={(value) =>
                                                setData("team", value)
                                            }
                                            disabled={processing}
                                        >
                                            <SelectTrigger className="w-full">
                                                <SelectValue placeholder="Chọn phòng ban" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {teams.map((team) => (
                                                    <SelectItem
                                                        key={team.id}
                                                        value={team.id.toString()}
                                                    >
                                                        {team.name}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.team && (
                                            <p className="text-sm text-red-500">
                                                {errors.team}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Right Column - Permissions */}
                        <div className="space-y-6">
                            <div className="bg-white rounded-lg">
                                <div className="flex items-center justify-between mb-6">
                                    <div>
                                        <h2 className="font-medium text-gray-800">
                                            Phân quyền truy cập
                                        </h2>
                                        <p className="text-xs text-gray-500">
                                            Thiết lập quyền truy cập cho nhân
                                            viên
                                        </p>
                                    </div>
                                </div>

                                <div className="mt-6 space-y-4">
                                    {Object.entries(permissions).map(
                                        ([permission, routes]) => (
                                            <div
                                                key={permission}
                                                className="rounded-md border border-gray-200 overflow-hidden"
                                            >
                                                <div className="bg-gray-50 px-4 py-3 flex items-center justify-between">
                                                    <div className="flex items-center space-x-3">
                                                        <Checkbox
                                                            id={`permission_${permission}`}
                                                            checked={routes.every(
                                                                (route) =>
                                                                    data
                                                                        .permissions[
                                                                        `${permission}_path_${route.name}`
                                                                    ]
                                                            )}
                                                            onCheckedChange={(
                                                                checked
                                                            ) => {
                                                                const newPermissions =
                                                                    {
                                                                        ...data.permissions,
                                                                    };
                                                                routes.forEach(
                                                                    (route) => {
                                                                        newPermissions[
                                                                            `${permission}_path_${route.name}`
                                                                        ] =
                                                                            checked ===
                                                                            true;
                                                                    }
                                                                );
                                                                setData(
                                                                    "permissions",
                                                                    newPermissions
                                                                );
                                                            }}
                                                            disabled={
                                                                processing
                                                            }
                                                        />
                                                        <Label
                                                            htmlFor={`permission_${permission}`}
                                                            className="text-sm font-medium text-gray-900"
                                                        >
                                                            {permission
                                                                .split("-")
                                                                .map(
                                                                    (word) =>
                                                                        word
                                                                            .charAt(
                                                                                0
                                                                            )
                                                                            .toUpperCase() +
                                                                        word.slice(
                                                                            1
                                                                        )
                                                                )
                                                                .join(" ")}
                                                        </Label>
                                                    </div>
                                                    <Button
                                                        type="button"
                                                        variant="ghost"
                                                        size="sm"
                                                        onClick={() =>
                                                            setOpenSections(
                                                                (prev) => ({
                                                                    ...prev,
                                                                    [permission]:
                                                                        !prev[
                                                                            permission
                                                                        ],
                                                                })
                                                            )
                                                        }
                                                        className="text-gray-500 hover:text-gray-700"
                                                        disabled={processing}
                                                    >
                                                        {openSections[
                                                            permission
                                                        ] ? (
                                                            <ChevronUp className="h-4 w-4" />
                                                        ) : (
                                                            <ChevronDown className="h-4 w-4" />
                                                        )}
                                                    </Button>
                                                </div>

                                                {openSections[permission] && (
                                                    <div className="border-t border-gray-200 divide-y divide-gray-200">
                                                        {routes.map((route) => (
                                                            <div
                                                                key={route.id}
                                                                className="px-4 py-3 hover:bg-gray-50"
                                                            >
                                                                <div className="flex items-center space-x-3">
                                                                    <Checkbox
                                                                        id={`${permission}_path_${route.name}`}
                                                                        checked={
                                                                            data
                                                                                .permissions[
                                                                                `${permission}_path_${route.name}`
                                                                            ] ||
                                                                            false
                                                                        }
                                                                        onCheckedChange={(
                                                                            checked
                                                                        ) => {
                                                                            setData(
                                                                                "permissions",
                                                                                {
                                                                                    ...data.permissions,
                                                                                    [`${permission}_path_${route.name}`]:
                                                                                        checked ===
                                                                                        true,
                                                                                }
                                                                            );
                                                                        }}
                                                                        disabled={
                                                                            processing
                                                                        }
                                                                    />
                                                                    <Label
                                                                        htmlFor={`${permission}_path_${route.name}`}
                                                                        className="text-sm text-gray-700"
                                                                    >
                                                                        {route.name
                                                                            .split(
                                                                                "."
                                                                            )
                                                                            .map(
                                                                                (
                                                                                    word
                                                                                ) =>
                                                                                    word
                                                                                        .charAt(
                                                                                            0
                                                                                        )
                                                                                        .toUpperCase() +
                                                                                    word.slice(
                                                                                        1
                                                                                    )
                                                                            )
                                                                            .join(
                                                                                " "
                                                                            )}
                                                                    </Label>
                                                                </div>
                                                            </div>
                                                        ))}
                                                    </div>
                                                )}
                                            </div>
                                        )
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Submit Button */}
                    <div className="mt-8 border-t border-gray-200 pt-6 flex justify-end">
                        <Button
                            type="submit"
                            disabled={processing}
                            className="px-8 py-2"
                        >
                            {processing ? "Đang xử lý..." : "Tạo nhân viên"}
                        </Button>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
