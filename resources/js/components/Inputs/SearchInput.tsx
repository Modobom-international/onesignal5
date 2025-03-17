import * as React from "react";

import { cn } from "@/lib/utils";
import { Input } from "@/components/ui/input";
import { ArrowRightIcon, SearchIcon } from "lucide-react";

const SearchInput = React.forwardRef<
    HTMLInputElement,
    React.ComponentProps<"input">
>(({ className, type, ...props }, ref) => {
    return (
        <div className="*:not-first:mt-2">
            <div className="relative">
                <Input
                    className={cn("peer ps-9 pe-9", className)}
                    placeholder="Search..."
                    type="search"
                    ref={ref}
                    {...props}
                />
                <div className="text-muted-foreground/80 pointer-events-none absolute inset-y-0 start-0 flex items-center justify-center ps-3 peer-disabled:opacity-50">
                    <SearchIcon size={16} />
                </div>
                <button
                    className="text-muted-foreground/80 hover:text-foreground focus-visible:border-ring focus-visible:ring-ring/50 absolute inset-y-0 end-0 flex h-full w-9 items-center justify-center rounded-e-md transition-[color,box-shadow] outline-none focus:z-10 focus-visible:ring-[3px] disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50"
                    aria-label="Submit search"
                    type="submit"
                >
                    <ArrowRightIcon size={16} aria-hidden="true" />
                </button>
            </div>
        </div>
    );
});
SearchInput.displayName = "SearchInput";

export { SearchInput };
