"use client";

import { Button } from "@/components/ui/button";
import { Calendar } from "@/components/ui/calendar";
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
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
import { format } from "date-fns";
import { CalendarIcon, MouseIcon } from "lucide-react";
import { useEffect, useMemo, useState } from "react";

interface HeatMapDialogProps {
    open?: boolean;
    onOpenChange?: (open: boolean) => void;
}

interface HeatmapData {
    x: number;
    y: number;
    intensity: number;
}

// Fake data generator for the heatmap
const generateFakeHeatmapData = (
    domain: string,
    path: string,
    date: Date | undefined,
    event: string
) => {
    const data: HeatmapData[] = [];
    const width = 1920;
    const height = 1080;
    const numPoints = 100;

    // Create clusters of points to make it look more realistic
    const clusters = [
        { x: width * 0.2, y: height * 0.3 }, // Top left cluster
        { x: width * 0.5, y: height * 0.2 }, // Top center
        { x: width * 0.8, y: height * 0.4 }, // Top right
        { x: width * 0.3, y: height * 0.7 }, // Bottom left
        { x: width * 0.7, y: height * 0.8 }, // Bottom right
    ];

    for (let i = 0; i < numPoints; i++) {
        // Pick a random cluster
        const cluster = clusters[Math.floor(Math.random() * clusters.length)];
        // Add some random variation around the cluster center
        const spread = 100;
        data.push({
            x: Math.min(
                width,
                Math.max(0, cluster.x + (Math.random() - 0.5) * spread)
            ),
            y: Math.min(
                height,
                Math.max(0, cluster.y + (Math.random() - 0.5) * spread)
            ),
            intensity: Math.random(),
        });
    }

    return data;
};

const HeatmapViz = ({
    data,
    width,
    height,
}: {
    data: HeatmapData[];
    width: number;
    height: number;
}) => {
    const points = useMemo(() => {
        return data.map((point, index) => {
            const radius = 20 * point.intensity;
            return (
                <circle
                    key={index}
                    cx={point.x * (width / 1920)}
                    cy={point.y * (height / 1080)}
                    r={radius}
                    fill="rgba(54, 162, 235, 0.3)"
                    style={{
                        mixBlendMode: "multiply",
                    }}
                />
            );
        });
    }, [data, width, height]);

    return (
        <svg
            width={width}
            height={height}
            style={{
                background: "white",
                borderRadius: "8px",
            }}
        >
            {points}
        </svg>
    );
};

export default function HeatMapDialog({
    open,
    onOpenChange,
}: HeatMapDialogProps) {
    const [domain, setDomain] = useState<string>("apkafe.com");
    const [path, setPath] = useState<string>("/");
    const [date, setDate] = useState<Date>();
    const [event, setEvent] = useState<string>("Mouse");
    const [heatmapData, setHeatmapData] = useState<HeatmapData[]>([]);
    const [showHeatmap, setShowHeatmap] = useState(false);

    const handleGenerate = () => {
        const data = generateFakeHeatmapData(domain, path, date, event);
        setHeatmapData(data);
        setShowHeatmap(true);
    };

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="max-w-4xl">
                <DialogHeader>
                    <DialogTitle>Generate Heatmap</DialogTitle>
                </DialogHeader>

                <div className="space-y-6">
                    {/* Search Filters */}
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {/* Domain Selection */}
                        <div className="space-y-2">
                            <Label htmlFor="domain-select">
                                Select the domain name
                            </Label>
                            <Select value={domain} onValueChange={setDomain}>
                                <SelectTrigger id="domain-select">
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

                        {/* Path Selection */}
                        <div className="space-y-2">
                            <Label htmlFor="path-select">Select the path</Label>
                            <Select value={path} onValueChange={setPath}>
                                <SelectTrigger id="path-select">
                                    <SelectValue placeholder="Select path" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="/">Home</SelectItem>
                                    <SelectItem value="/about">
                                        About
                                    </SelectItem>
                                    <SelectItem value="/products">
                                        Products
                                    </SelectItem>
                                    <SelectItem value="/contact">
                                        Contact
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        {/* Date Picker */}
                        <div className="space-y-2">
                            <Label>Select date</Label>
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

                        {/* Event Type Selection */}
                        <div className="space-y-2">
                            <Label htmlFor="event-select">Choose events</Label>
                            <Select value={event} onValueChange={setEvent}>
                                <SelectTrigger id="event-select">
                                    <SelectValue placeholder="Select event" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="Mouse">
                                        <div className="flex items-center">
                                            <MouseIcon className="mr-2 h-4 w-4" />
                                            Mouse
                                        </div>
                                    </SelectItem>
                                    <SelectItem value="Click">Click</SelectItem>
                                    <SelectItem value="Scroll">
                                        Scroll
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>

                    {/* Generate Button */}
                    <div className="flex justify-end">
                        <Button onClick={handleGenerate} className="w-32">
                            Generate
                        </Button>
                    </div>

                    {/* Heatmap Visualization */}
                    {showHeatmap && (
                        <div className="relative mt-4 h-[600px] w-full rounded-lg border bg-background p-4">
                            <div className="h-full w-full flex items-center justify-center">
                                <HeatmapViz
                                    data={heatmapData}
                                    width={800}
                                    height={500}
                                />
                            </div>
                            <div className="absolute bottom-4 right-4 text-sm text-muted-foreground">
                                {heatmapData.length} interaction points
                            </div>
                        </div>
                    )}
                </div>
            </DialogContent>
        </Dialog>
    );
}
