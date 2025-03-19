"use client";

import HtmlSourceDataTable from "@/components/HtmlSource/DataTable";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { ChevronRight, Home } from "lucide-react";

export default function HtmlSourcePage() {
    return (
        <AuthenticatedLayout title="HTML Source Management">
            <div className="mb-8 border-b border-border pb-6">
                {/* Breadcrumbs */}
                <div className="flex items-center text-sm text-muted-foreground mb-4">
                    <Home className="w-4 h-4" />
                    <ChevronRight className="w-4 h-4 mx-2" />
                    <span>HTML Source</span>
                </div>

                {/* Header Section */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight flex items-center gap-2">
                            HTML Source Management
                        </h1>
                        <p className="text-muted-foreground mt-1">
                            Monitor, search, and analyze collected HTML sources
                            from various applications and devices
                        </p>
                    </div>
                </div>
            </div>

            {/* Statistics Cards */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div className="bg-card rounded-lg p-4 border border-border">
                    <h3 className="text-sm font-medium text-muted-foreground">
                        Total Sources
                    </h3>
                    <p className="text-2xl font-bold mt-1">1,284</p>
                </div>
                <div className="bg-card rounded-lg p-4 border border-border">
                    <h3 className="text-sm font-medium text-muted-foreground">
                        Unique URLs
                    </h3>
                    <p className="text-2xl font-bold mt-1">857</p>
                </div>
                <div className="bg-card rounded-lg p-4 border border-border">
                    <h3 className="text-sm font-medium text-muted-foreground">
                        Applications
                    </h3>
                    <p className="text-2xl font-bold mt-1">12</p>
                </div>
                <div className="bg-card rounded-lg p-4 border border-border">
                    <h3 className="text-sm font-medium text-muted-foreground">
                        Countries
                    </h3>
                    <p className="text-2xl font-bold mt-1">24</p>
                </div>
            </div>

            <div>
                <HtmlSourceDataTable />
            </div>
        </AuthenticatedLayout>
    );
}
