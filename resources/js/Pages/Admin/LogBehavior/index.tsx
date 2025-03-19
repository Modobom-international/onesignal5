"use client";

import LogBehaviorDataTable from "@/components/LogBehavior/DataTable";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { ChevronRight, Code, Home } from "lucide-react";
import { Badge } from "@/components/ui/badge";

export default function LogBehaviorPage() {
    return (
        <AuthenticatedLayout title="Log Behavior Management">
            <div className="mb-8 border-b border-border pb-6">
                {/* Breadcrumbs */}
                <div className="flex items-center text-sm text-muted-foreground mb-4">
                    <Home className="w-4 h-4" />
                    <ChevronRight className="w-4 h-4 mx-2" />
                    <span>Log Behavior</span>
                </div>

                {/* Header Section */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight flex items-center gap-2">
                            Log Behavior Management
                        </h1>
                        <p className="text-muted-foreground mt-1">
                            Monitor, search, and analyze collected log behavior
                            from various applications and devices
                        </p>
                    </div>
                </div>
            </div>

            {/* Statistics Cards */}
            {/* <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div className="bg-card rounded-lg p-4 border border-border">
                    <h3 className="text-sm font-medium text-muted-foreground">
                        Total Logs
                    </h3>
                    <p className="text-2xl font-bold mt-1">1,284</p>
                </div>
                <div className="bg-card rounded-lg p-4 border border-border">
                    <h3 className="text-sm font-medium text-muted-foreground">
                        Applications
                    </h3>
                    <p className="text-2xl font-bold mt-1">12</p>
                </div>
                <div className="bg-card rounded-lg p-4 border border-border">
                    <h3 className="text-sm font-medium text-muted-foreground">
                        Networks
                    </h3>
                    <p className="text-2xl font-bold mt-1">4</p>
                </div>
                <div className="bg-card rounded-lg p-4 border border-border">
                    <h3 className="text-sm font-medium text-muted-foreground">
                        Countries
                    </h3>
                    <p className="text-2xl font-bold mt-1">24</p>
                </div>
            </div> */}

            {/* Platform Distribution */}
            {/* <div className="mb-8">
                <h2 className="text-lg font-semibold mb-4">
                    Platform Distribution
                </h2>
                <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div className="bg-card rounded-lg p-4 border border-border">
                        <div className="flex items-center justify-between">
                            <span className="text-sm font-medium">
                                Facebook
                            </span>
                            <Badge variant="secondary">150</Badge>
                        </div>
                    </div>
                    <div className="bg-card rounded-lg p-4 border border-border">
                        <div className="flex items-center justify-between">
                            <span className="text-sm font-medium">TikTok</span>
                            <Badge variant="outline">75</Badge>
                        </div>
                    </div>
                    <div className="bg-card rounded-lg p-4 border border-border">
                        <div className="flex items-center justify-between">
                            <span className="text-sm font-medium">Google</span>
                            <Badge variant="destructive">200</Badge>
                        </div>
                    </div>
                    <div className="bg-card rounded-lg p-4 border border-border">
                        <div className="flex items-center justify-between">
                            <span className="text-sm font-medium">
                                Instagram
                            </span>
                            <Badge variant="secondary">120</Badge>
                        </div>
                    </div>
                    <div className="bg-card rounded-lg p-4 border border-border">
                        <div className="flex items-center justify-between">
                            <span className="text-sm font-medium">YouTube</span>
                            <Badge variant="destructive">180</Badge>
                        </div>
                    </div>
                </div>
            </div> */}

            <div>
                <LogBehaviorDataTable />
            </div>
        </AuthenticatedLayout>
    );
}
