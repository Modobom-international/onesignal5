import {
    BellIcon,
    GridIcon,
    HelpCircleIcon,
    Settings2Icon,
    SidebarIcon,
} from "lucide-react";

import { SearchForm } from "@/components/Layout/search-form";
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";
import { Button } from "@/components/ui/button";
import { Separator } from "@/components/ui/separator";
import { useSidebar } from "@/components/ui/sidebar";
import NotificationsButton from "@/components/Notifications";

export function SiteHeader() {
    const { toggleSidebar } = useSidebar();

    return (
        <header className="flex sticky top-0 z-50 w-full items-center border-b bg-background">
            <div className="flex h-[--header-height] w-full items-center justify-between gap-2 px-4">
                <div className="flex items-center gap-3">
                    <Button
                        className="h-8 w-8"
                        variant="ghost"
                        size="icon"
                        onClick={toggleSidebar}
                    >
                        <SidebarIcon />
                    </Button>
                    <Separator orientation="vertical" className="mr-2 h-4" />
                </div>

                <div className="flex items-center gap-3">
                    <SearchForm className="w-[500px]" />

                    <div className="flex items-center gap-1">
                        <Button
                            variant="ghost"
                            size="icon"
                            className="h-9 w-9"
                            onClick={toggleSidebar}
                        >
                            <GridIcon className="h-[18px] w-[18px] text-muted-foreground" />
                        </Button>

                        <NotificationsButton />

                        <Button variant="ghost" size="icon" className="h-9 w-9">
                            <Settings2Icon className="h-[18px] w-[18px] text-muted-foreground" />
                        </Button>
                    </div>
                </div>
            </div>
        </header>
    );
}
