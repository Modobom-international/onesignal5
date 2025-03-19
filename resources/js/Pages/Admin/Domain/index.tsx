import DomainDataTable from "@/components/Domain/DataTable";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { ChevronRight, Home } from "lucide-react";
import React from "react";

export default function DomainPage() {
    return (
        <AuthenticatedLayout title="Domain">
            {/* Header Section */}
            <div className="mb-8 border-b border-border pb-6">
                {/* Breadcrumbs */}
                <div className="flex items-center text-sm text-muted-foreground mb-4">
                    <Home className="w-4 h-4" />
                    <ChevronRight className="w-4 h-4 mx-2" />
                    <span>Domain</span>
                </div>

                {/* Welcome Message */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">
                            Domain
                        </h1>
                        <p className="text-muted-foreground mt-1">
                            Managing and monitoring of the domain system
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <DomainDataTable />
            </div>
        </AuthenticatedLayout>
    );
}
