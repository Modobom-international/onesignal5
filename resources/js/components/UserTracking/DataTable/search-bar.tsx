"use client";

import { Button } from "@/components/ui/button";
import { Calendar } from "@/components/ui/calendar";
import { Label } from "@/components/ui/label";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { cn } from "@/lib/utils";
import { CalendarIcon, SearchIcon, BarChart2Icon } from "lucide-react";
import { format } from "date-fns";
import { useState } from "react";
import HeatMapDialog from "../../UserTracking/Dialog/HeatMapDialog";

interface SearchBarProps {
    onSearch?: (filters: { domain: string; date: Date | undefined }) => void;
}

export function SearchBar({ onSearch }: SearchBarProps) {
    const [date, setDate] = useState<Date>();
    const [domain, setDomain] = useState<string>("apkafe.com");
    const [showHeatmap, setShowHeatmap] = useState(false);

    const handleSearch = () => {
        onSearch?.({
            domain,
            date,
        });
    };

    return (
        <>
            <div className="mb-6 space-y-6">
                <div className="flex gap-4">
                    {/* Domain Selection */}
                    <div className="space-y-2 w-56">
                        <Label htmlFor="domain-select">Domain</Label>
                        <Select
                            value={domain}
                            onValueChange={(value) => {
                                setDomain(value);
                            }}
                        >
                            <SelectTrigger
                                id="domain-select"
                                className="w-full"
                            >
                                <SelectValue placeholder="Select domain" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="apkafe.com">
                                    apkafe.com
                                </SelectItem>
                                <SelectItem value="vnitourist.com">
                                    vnitourist.com
                                </SelectItem>
                                <SelectItem value="vnifood.com">
                                    vnifood.com
                                </SelectItem>
                                <SelectItem value="betonamuryori.com">
                                    betonamuryori.com
                                </SelectItem>
                                <SelectItem value="lifecompass365.com">
                                    lifecompass365.com
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    {/* Date Picker */}
                    <div className="space-y-2 w-56">
                        <Label>Date</Label>
                        <Popover>
                            <PopoverTrigger asChild>
                                <Button
                                    variant="outline"
                                    className={cn(
                                        "w-full justify-start text-left font-normal",
                                        !date && "text-muted-foreground"
                                    )}
                                >
                                    <CalendarIcon className="mr-2 h-4 w-4" />
                                    {date ? (
                                        format(date, "PPP")
                                    ) : (
                                        <span>Pick a date</span>
                                    )}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent
                                className="w-auto p-0"
                                align="start"
                            >
                                <Calendar
                                    mode="single"
                                    selected={date}
                                    onSelect={setDate}
                                    initialFocus
                                />
                            </PopoverContent>
                        </Popover>
                    </div>

                    {/* Search Button */}
                    <div className="flex items-end gap-2">
                        <Button
                            onClick={handleSearch}
                            className="w-full sm:w-auto"
                        >
                            <SearchIcon className="mr-2 h-4 w-4" />
                            Search
                        </Button>
                        <Button
                            variant="outline"
                            onClick={() => setShowHeatmap(true)}
                            className="w-full sm:w-auto"
                        >
                            <BarChart2Icon className="mr-2 h-4 w-4" />
                            Heatmap
                        </Button>
                    </div>
                </div>
            </div>

            <HeatMapDialog open={showHeatmap} onOpenChange={setShowHeatmap} />
        </>
    );
}
