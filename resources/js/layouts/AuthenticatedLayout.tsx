import { AppSidebar } from "@/components/Layout/Sidebar/app-sidebar";
import { SiteHeader } from "@/components/Layout/site-header";
import { SidebarInset, SidebarProvider } from "@/components/ui/sidebar";
import { Head } from "@inertiajs/react";
import { PropsWithChildren } from "react";
interface Props {
    // user: User;
    // header?: React.ReactNode;
    children: React.ReactNode;
    title: string;
}

export default function AuthenticatedLayout({
    children,
    title,
}: PropsWithChildren<Props>) {
    return (
        <div className="[--header-height:calc(theme(spacing.14))]">
            <Head title={title} />
            <SidebarProvider className="flex flex-col">
                <SiteHeader />
                <div className="flex flex-1">
                    <AppSidebar />
                    <SidebarInset>
                        <div className="flex flex-1 flex-col gap-4 p-4">
                            {children}
                        </div>
                    </SidebarInset>
                </div>
            </SidebarProvider>
        </div>
    );
}
