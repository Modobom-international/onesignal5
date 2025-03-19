"use client";

import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Separator } from "@/components/ui/separator";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { AlertCircle, ChevronRight, Home, Lock, User } from "lucide-react";
import { useState } from "react";

interface UserProfile {
    name: string;
    email: string;
    title: string;
    position: string;
    team: string;
    salary: number;
    joinDate: string;
}

export default function ProfilePage() {
    const [user, setUser] = useState<UserProfile>({
        name: "John Doe",
        email: "john@example.com",
        title: "Staff",
        position: "Developer",
        team: "Engineering",
        salary: 0,
        joinDate: new Date().toLocaleDateString(),
    });

    const getInitials = (name: string) => {
        return name.charAt(0).toUpperCase();
    };

    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(amount);
    };

    return (
        <AuthenticatedLayout title="Thông tin cá nhân">
            {/* Header Section */}
            <div className="mb-8">
                {/* Breadcrumbs */}
                <div className="flex items-center text-sm text-muted-foreground mb-4">
                    <Home className="w-4 h-4" />
                    <ChevronRight className="w-4 h-4 mx-2" />
                    <span>Thông tin cá nhân</span>
                </div>

                {/* Welcome Message */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">
                            Xin chào, {user.name}!
                        </h1>
                        <p className="text-muted-foreground mt-1">
                            Quản lý thông tin cá nhân và cài đặt tài khoản của
                            bạn
                        </p>
                    </div>
                    <div className="flex items-center gap-4">
                        <div className="text-right">
                            <p className="text-sm font-medium">Trạng thái</p>
                            <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Đang hoạt động
                            </span>
                        </div>
                        <Separator orientation="vertical" className="h-12" />
                        <div className="text-right">
                            <p className="text-sm font-medium">
                                Đăng nhập lần cuối
                            </p>
                            <p className="text-sm text-muted-foreground">
                                {new Date().toLocaleDateString("vi-VN", {
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric",
                                })}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {/* Left Sidebar */}
                <div className="lg:col-span-3 space-y-6">
                    {/* Profile Card */}
                    <Card>
                        <CardContent className="pt-6">
                            <div className="flex flex-col items-center">
                                <div className="h-32 w-32 rounded-full bg-primary flex items-center justify-center">
                                    <span className="text-5xl font-medium text-primary-foreground">
                                        {getInitials(user.name)}
                                    </span>
                                </div>
                                <h2 className="mt-4 text-xl font-bold">
                                    {user.name}
                                </h2>
                                <p className="text-sm text-muted-foreground">
                                    {user.email}
                                </p>
                                <div className="mt-4">
                                    <span className="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full">
                                        {user.title}
                                    </span>
                                </div>
                            </div>
                        </CardContent>
                        <Separator className="my-4" />
                        <CardContent className="grid grid-cols-2 gap-4">
                            <div className="text-center">
                                <span className="text-sm font-medium">
                                    Position
                                </span>
                                <p className="text-sm text-muted-foreground">
                                    {user.position}
                                </p>
                            </div>
                            <div className="text-center">
                                <span className="text-sm font-medium">
                                    Team
                                </span>
                                <p className="text-sm text-muted-foreground">
                                    {user.team}
                                </p>
                            </div>
                        </CardContent>
                    </Card>

                    {/* Additional Info Card */}
                    <Card>
                        <CardContent className="pt-6">
                            <h3 className="text-sm font-medium text-muted-foreground mb-4">
                                Additional Information
                            </h3>
                            <div className="space-y-4">
                                <div className="flex justify-between">
                                    <span className="text-sm text-muted-foreground">
                                        Join Date
                                    </span>
                                    <span className="text-sm font-medium">
                                        {user.joinDate}
                                    </span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-sm text-muted-foreground">
                                        Salary
                                    </span>
                                    <span className="text-sm font-medium">
                                        {formatCurrency(user.salary)}
                                    </span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Main Content */}
                <div className="lg:col-span-9 space-y-6">
                    {/* Profile Information Form */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <User className="w-5 h-5" />
                                Personal Information
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <form className="space-y-4">
                                <div className="grid grid-cols-2 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="name">Name</Label>
                                        <Input
                                            id="name"
                                            defaultValue={user.name}
                                        />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="email">Email</Label>
                                        <Input
                                            id="email"
                                            type="email"
                                            defaultValue={user.email}
                                        />
                                    </div>
                                </div>
                                <Button className="mt-4">Save Changes</Button>
                            </form>
                        </CardContent>
                    </Card>

                    {/* Password Update Form */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <Lock className="w-5 h-5" />
                                Security
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <form className="space-y-4">
                                <div className="grid grid-cols-2 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="current_password">
                                            Current Password
                                        </Label>
                                        <Input
                                            id="current_password"
                                            type="password"
                                        />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="new_password">
                                            New Password
                                        </Label>
                                        <Input
                                            id="new_password"
                                            type="password"
                                        />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="confirm_password">
                                            Confirm Password
                                        </Label>
                                        <Input
                                            id="confirm_password"
                                            type="password"
                                        />
                                    </div>
                                </div>
                                <Button className="mt-4">
                                    Update Password
                                </Button>
                            </form>
                        </CardContent>
                    </Card>

                    {/* Danger Zone */}
                    <Card className="border-destructive">
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2 text-destructive">
                                <AlertCircle className="w-5 h-5" />
                                Danger Zone
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <p className="text-sm text-muted-foreground mb-4">
                                Once you delete your account, there is no going
                                back. Please be certain.
                            </p>
                            <Button variant="destructive">
                                Delete Account
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
