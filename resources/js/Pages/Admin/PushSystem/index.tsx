import PushSystemDataTable from "@/components/PushSystem/DataTable";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { Activity, ChevronRight, Globe, Home, Users } from "lucide-react";

export default function PushSystemPage() {
    return (
        <AuthenticatedLayout title="Push System">
            {/* Header Section */}
            <div className="mb-8 border-b border-border pb-6">
                {/* Breadcrumbs */}
                <div className="flex items-center text-sm text-muted-foreground mb-4">
                    <Home className="w-4 h-4" />
                    <ChevronRight className="w-4 h-4 mx-2" />
                    <span>Push System</span>
                </div>

                {/* Welcome Message */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">
                            Push System
                        </h1>
                        <p className="text-muted-foreground mt-1">
                            Managing and monitoring of the push notification
                            system
                        </p>
                    </div>
                </div>
            </div>

            {/* Statistics Cards */}
            <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3 mb-8">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">
                            Total Users
                        </CardTitle>
                        <Users className="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">739,157</div>
                        <p className="text-xs text-muted-foreground">
                            Across all countries
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">
                            Active Today
                        </CardTitle>
                        <Activity className="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">37</div>
                        <p className="text-xs text-muted-foreground">
                            Users active in the last 24 hours
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">
                            Countries
                        </CardTitle>
                        <Globe className="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">6</div>
                        <p className="text-xs text-muted-foreground">
                            Active regions
                        </p>
                    </CardContent>
                </Card>
            </div>

            {/* DataTable */}
            <div>
                <PushSystemDataTable />
            </div>
        </AuthenticatedLayout>
    );
}
