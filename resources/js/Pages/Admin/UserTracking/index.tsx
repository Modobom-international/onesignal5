"use client";

import UserTrackingDataTable from "@/components/UserTracking/DataTable";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { ChevronRight, Home } from "lucide-react";

export default function UserTrackingPage() {
    return (
        <AuthenticatedLayout title="User Tracking">
            {/* Header Section */}
            <div className="mb-8">
                {/* Breadcrumbs */}
                <div className="flex items-center text-sm text-muted-foreground mb-4">
                    <Home className="w-4 h-4" />
                    <ChevronRight className="w-4 h-4 mx-2" />
                    <span>User Tracking</span>
                </div>

                {/* Welcome Message */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">
                            User Tracking
                        </h1>
                        <p className="text-muted-foreground mt-1">
                            View and analyze user behavior on the website
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <UserTrackingDataTable />
            </div>
        </AuthenticatedLayout>
    );
}
