"use client";

import { Button } from "@/components/ui/button";
import { Calendar } from "@/components/ui/calendar";
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
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
import { zodResolver } from "@hookform/resolvers/zod";
import { format } from "date-fns";
import { CalendarIcon, SearchIcon } from "lucide-react";
import { useForm } from "react-hook-form";
import { z } from "zod";

const formSchema = z.object({
    day: z.date().optional(),
    application: z.string().optional(),
    nation: z.string().optional(),
    device: z.string().optional(),
    platform: z.string().optional(),
    sourceKeyword: z.string().optional(),
});

type SearchBarProps = {
    onSearch: (values: z.infer<typeof formSchema>) => void;
    applications: { value: string; label: string }[];
    nations: { value: string; label: string }[];
    platforms: { value: string; label: string }[];
};

export function SearchBar({
    onSearch,
    applications = [],
    nations = [],
    platforms = [],
}: SearchBarProps) {
    const form = useForm<z.infer<typeof formSchema>>({
        resolver: zodResolver(formSchema),
        defaultValues: {
            sourceKeyword: "",
            device: "",
            platform: "",
        },
    });

    const handleSubmit = (values: z.infer<typeof formSchema>) => {
        onSearch(values);
    };

    return (
        <Form {...form}>
            <form
                onSubmit={form.handleSubmit(handleSubmit)}
                className="grid gap-4 md:grid-cols-6"
            >
                {/* Day Selection */}
                <FormField
                    control={form.control}
                    name="day"
                    render={({ field }) => (
                        <FormItem>
                            <FormLabel>Day</FormLabel>
                            <Popover>
                                <PopoverTrigger asChild>
                                    <FormControl>
                                        <Button
                                            variant={"outline"}
                                            className={cn(
                                                "w-full pl-3 text-left font-normal",
                                                !field.value &&
                                                    "text-muted-foreground"
                                            )}
                                        >
                                            {field.value ? (
                                                format(field.value, "PPP")
                                            ) : (
                                                <span>Pick a date</span>
                                            )}
                                            <CalendarIcon className="ml-auto h-4 w-4 opacity-50" />
                                        </Button>
                                    </FormControl>
                                </PopoverTrigger>
                                <PopoverContent
                                    className="w-auto p-0"
                                    align="start"
                                >
                                    <Calendar
                                        mode="single"
                                        selected={field.value}
                                        onSelect={field.onChange}
                                        initialFocus
                                    />
                                </PopoverContent>
                            </Popover>
                        </FormItem>
                    )}
                />

                {/* Application Selection */}
                <FormField
                    control={form.control}
                    name="application"
                    render={({ field }) => (
                        <FormItem>
                            <FormLabel>Application</FormLabel>
                            <Select
                                onValueChange={field.onChange}
                                defaultValue={field.value}
                            >
                                <FormControl>
                                    <SelectTrigger>
                                        <SelectValue placeholder="All applications" />
                                    </SelectTrigger>
                                </FormControl>
                                <SelectContent>
                                    <SelectItem value="all">
                                        All applications
                                    </SelectItem>
                                    {applications.map((app) => (
                                        <SelectItem
                                            key={app.value}
                                            value={app.value}
                                        >
                                            {app.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                        </FormItem>
                    )}
                />

                {/* Nation Selection */}
                <FormField
                    control={form.control}
                    name="nation"
                    render={({ field }) => (
                        <FormItem>
                            <FormLabel>Nation</FormLabel>
                            <Select
                                onValueChange={field.onChange}
                                defaultValue={field.value}
                            >
                                <FormControl>
                                    <SelectTrigger>
                                        <SelectValue placeholder="All nations" />
                                    </SelectTrigger>
                                </FormControl>
                                <SelectContent>
                                    <SelectItem value="all">
                                        All nations
                                    </SelectItem>
                                    {nations.map((nation) => (
                                        <SelectItem
                                            key={nation.value}
                                            value={nation.value}
                                        >
                                            {nation.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                        </FormItem>
                    )}
                />

                {/* Platform Selection */}
                <FormField
                    control={form.control}
                    name="platform"
                    render={({ field }) => (
                        <FormItem>
                            <FormLabel>Platform</FormLabel>
                            <Select
                                onValueChange={field.onChange}
                                defaultValue={field.value}
                            >
                                <FormControl>
                                    <SelectTrigger>
                                        <SelectValue placeholder="All platforms" />
                                    </SelectTrigger>
                                </FormControl>
                                <SelectContent>
                                    <SelectItem value="all">
                                        All platforms
                                    </SelectItem>
                                    {platforms.map((platform) => (
                                        <SelectItem
                                            key={platform.value}
                                            value={platform.value}
                                        >
                                            {platform.label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                        </FormItem>
                    )}
                />

                {/* Device Input */}
                <FormField
                    control={form.control}
                    name="device"
                    render={({ field }) => (
                        <FormItem>
                            <FormLabel>Device</FormLabel>
                            <FormControl>
                                <Input
                                    placeholder="Enter device ID"
                                    {...field}
                                />
                            </FormControl>
                        </FormItem>
                    )}
                />

                {/* Source Keyword Input */}
                <FormField
                    control={form.control}
                    name="sourceKeyword"
                    render={({ field }) => (
                        <FormItem>
                            <FormLabel>Source keyword</FormLabel>
                            <div className="flex items-center gap-2">
                                <FormControl>
                                    <Input
                                        placeholder="Search in source"
                                        {...field}
                                    />
                                </FormControl>
                                <Button type="submit">
                                    <SearchIcon className="h-4 w-4" />
                                </Button>
                            </div>
                        </FormItem>
                    )}
                />
            </form>
        </Form>
    );
}
