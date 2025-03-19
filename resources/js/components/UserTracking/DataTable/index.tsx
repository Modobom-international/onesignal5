"use client";
import { Button } from "@/components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Label } from "@/components/ui/label";
import {
    Pagination,
    PaginationContent,
    PaginationItem,
} from "@/components/ui/pagination";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { cn } from "@/lib/utils";
import {
    Column,
    ColumnDef,
    flexRender,
    getCoreRowModel,
    getSortedRowModel,
    SortingState,
    useReactTable,
} from "@tanstack/react-table";
import {
    ArrowLeftToLineIcon,
    ArrowRightToLineIcon,
    ChevronDownIcon,
    ChevronFirstIcon,
    ChevronLastIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    ChevronUpIcon,
    EllipsisIcon,
    MoreHorizontalIcon,
    PencilIcon,
    PinOffIcon,
    TrashIcon,
    UserIcon,
} from "lucide-react";
import { CSSProperties, useEffect, useState } from "react";
import { SearchBar } from "./search-bar";

type Item = {
    id: string;
    lastTime: string;
    ipAddress: string;
    device: string;
};

// Helper function to compute pinning styles for columns
const getPinningStyles = (column: Column<Item>): CSSProperties => {
    const isPinned = column.getIsPinned();
    return {
        left: isPinned === "left" ? `${column.getStart("left")}px` : undefined,
        right:
            isPinned === "right" ? `${column.getAfter("right")}px` : undefined,
        position: isPinned ? "sticky" : "relative",
        width: column.getSize(),
        zIndex: isPinned ? 1 : 0,
        backgroundColor: isPinned ? "#fff" : "transparent",
    };
};

const columns: ColumnDef<Item>[] = [
    {
        header: "ID",
        accessorKey: "id",
        cell: ({ row }) => (
            <div className="truncate font-medium text-muted-foreground">
                {row.getValue("id")}
            </div>
        ),
    },
    {
        header: "Last Time",
        accessorKey: "lastTime",
        cell: ({ row }) => (
            <div className="truncate font-medium">
                {row.getValue("lastTime")}
            </div>
        ),
    },
    {
        header: "IP Address",
        accessorKey: "ipAddress",
        cell: ({ row }) => (
            <div className="truncate">{row.getValue("ipAddress")}</div>
        ),
    },
    {
        header: "Device",
        accessorKey: "device",
        cell: ({ row }) => (
            <div className="truncate">{row.getValue("device")}</div>
        ),
    },
    {
        id: "actions",
        header: "Actions",
        cell: ({ row }) => {
            const user = row.original;

            return (
                <div className="flex justify-end">
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button
                                variant="ghost"
                                className="flex h-8 w-8 p-0 data-[state=open]:bg-muted"
                            >
                                <MoreHorizontalIcon className="h-4 w-4" />
                                <span className="sr-only">Open menu</span>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" className="w-[160px]">
                            <DropdownMenuItem>
                                <UserIcon className="mr-2 h-4 w-4" />
                                View Details
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <PencilIcon className="mr-2 h-4 w-4" />
                                Edit
                            </DropdownMenuItem>
                            <DropdownMenuItem className="text-destructive focus:text-destructive">
                                <TrashIcon className="mr-2 h-4 w-4" />
                                Delete
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            );
        },
    },
];

export default function UserTrackingDataTable() {
    const [data, setData] = useState<Item[]>([]);
    const [sorting, setSorting] = useState<SortingState>([
        {
            id: "name",
            desc: false,
        },
    ]);

    const handleSearch = (filters: {
        domain: string;
        date: Date | undefined;
    }) => {
        // Here you would typically make an API call with the filters
        // For now, we'll just log them
        console.log("Search filters:", filters);
    };

    useEffect(() => {
        // Simulated data based on the PHP controller's structure
        setData([
            {
                id: "usr_" + Math.random().toString(36).substr(2, 9),
                lastTime: new Date(
                    Date.now() - Math.floor(Math.random() * 86400000)
                ).toLocaleString(),
                ipAddress:
                    "192.168." +
                    Math.floor(Math.random() * 255) +
                    "." +
                    Math.floor(Math.random() * 255),
                device: "Chrome / Windows 10",
            },
            {
                id: "usr_" + Math.random().toString(36).substr(2, 9),
                lastTime: new Date(
                    Date.now() - Math.floor(Math.random() * 86400000)
                ).toLocaleString(),
                ipAddress:
                    "172.16." +
                    Math.floor(Math.random() * 255) +
                    "." +
                    Math.floor(Math.random() * 255),
                device: "Safari / macOS",
            },
            {
                id: "usr_" + Math.random().toString(36).substr(2, 9),
                lastTime: new Date(
                    Date.now() - Math.floor(Math.random() * 86400000)
                ).toLocaleString(),
                ipAddress:
                    "10.0." +
                    Math.floor(Math.random() * 255) +
                    "." +
                    Math.floor(Math.random() * 255),
                device: "Firefox / Ubuntu",
            },
            {
                id: "usr_" + Math.random().toString(36).substr(2, 9),
                lastTime: new Date(
                    Date.now() - Math.floor(Math.random() * 86400000)
                ).toLocaleString(),
                ipAddress:
                    "192.168." +
                    Math.floor(Math.random() * 255) +
                    "." +
                    Math.floor(Math.random() * 255),
                device: "Chrome / Android",
            },
            {
                id: "usr_" + Math.random().toString(36).substr(2, 9),
                lastTime: new Date(
                    Date.now() - Math.floor(Math.random() * 86400000)
                ).toLocaleString(),
                ipAddress:
                    "172.16." +
                    Math.floor(Math.random() * 255) +
                    "." +
                    Math.floor(Math.random() * 255),
                device: "Safari / iOS",
            },
        ]);
    }, []);

    const table = useReactTable({
        data,
        columns,
        columnResizeMode: "onChange",
        getCoreRowModel: getCoreRowModel(),
        getSortedRowModel: getSortedRowModel(),
        onSortingChange: setSorting,
        state: {
            sorting,
        },
        enableSortingRemoval: false,
    });

    return (
        <>
            <SearchBar onSearch={handleSearch} />
            <div className="w-full">
                <Table
                    className="w-full [&_td]:border-border [&_th]:border-border table-fixed border-separate border-spacing-0 [&_tfoot_td]:border-t [&_th]:border-b [&_tr]:border-none [&_tr:not(:last-child)_td]:border-b"
                    style={{
                        minWidth: "100%",
                    }}
                >
                    <TableHeader>
                        {table.getHeaderGroups().map((headerGroup) => (
                            <TableRow
                                key={headerGroup.id}
                                className="bg-muted/50"
                            >
                                {headerGroup.headers.map((header) => {
                                    const { column } = header;
                                    const isPinned = column.getIsPinned();
                                    const isLastLeftPinned =
                                        isPinned === "left" &&
                                        column.getIsLastColumn("left");
                                    const isFirstRightPinned =
                                        isPinned === "right" &&
                                        column.getIsFirstColumn("right");

                                    return (
                                        <TableHead
                                            key={header.id}
                                            className="[&[data-pinned][data-last-col]]:border-border data-pinned:bg-muted/90 relative h-10 truncate border-t data-pinned:backdrop-blur-xs [&:not([data-pinned]):has(+[data-pinned])_div.cursor-col-resize:last-child]:opacity-0 [&[data-last-col=left]_div.cursor-col-resize:last-child]:opacity-0 [&[data-pinned=left][data-last-col=left]]:border-r [&[data-pinned=right]:last-child_div.cursor-col-resize:last-child]:opacity-0 [&[data-pinned=right][data-last-col=right]]:border-l"
                                            colSpan={header.colSpan}
                                            style={{
                                                ...getPinningStyles(column),
                                            }}
                                            data-pinned={isPinned || undefined}
                                            data-last-col={
                                                isLastLeftPinned
                                                    ? "left"
                                                    : isFirstRightPinned
                                                    ? "right"
                                                    : undefined
                                            }
                                            aria-sort={
                                                header.column.getIsSorted() ===
                                                "asc"
                                                    ? "ascending"
                                                    : header.column.getIsSorted() ===
                                                      "desc"
                                                    ? "descending"
                                                    : "none"
                                            }
                                        >
                                            <div
                                                className={cn(
                                                    "flex items-center justify-between gap-2",
                                                    header.column.getCanSort() &&
                                                        "cursor-pointer select-none"
                                                )}
                                                onClick={
                                                    header.column.getCanSort()
                                                        ? header.column.getToggleSortingHandler()
                                                        : undefined
                                                }
                                                onKeyDown={(e) => {
                                                    if (
                                                        header.column.getCanSort() &&
                                                        (e.key === "Enter" ||
                                                            e.key === " ")
                                                    ) {
                                                        e.preventDefault();
                                                        header.column.getToggleSortingHandler()?.(
                                                            e
                                                        );
                                                    }
                                                }}
                                                tabIndex={
                                                    header.column.getCanSort()
                                                        ? 0
                                                        : undefined
                                                }
                                            >
                                                <div className="flex items-center gap-1">
                                                    <span className="truncate">
                                                        {header.isPlaceholder
                                                            ? null
                                                            : flexRender(
                                                                  header.column
                                                                      .columnDef
                                                                      .header,
                                                                  header.getContext()
                                                              )}
                                                    </span>
                                                    {header.column.getCanSort() && (
                                                        <div className="flex items-center">
                                                            {header.column.getIsSorted() ===
                                                            "asc" ? (
                                                                <ChevronUpIcon className="size-4 shrink-0 opacity-60" />
                                                            ) : header.column.getIsSorted() ===
                                                              "desc" ? (
                                                                <ChevronDownIcon className="size-4 shrink-0 opacity-60" />
                                                            ) : null}
                                                        </div>
                                                    )}
                                                </div>
                                                {/* Pin/Unpin column controls with enhanced accessibility */}
                                                {!header.isPlaceholder &&
                                                    header.column.getCanPin() &&
                                                    (header.column.getIsPinned() ? (
                                                        <Button
                                                            size="icon"
                                                            variant="ghost"
                                                            className="-mr-1 size-7 shadow-none"
                                                            onClick={() =>
                                                                header.column.pin(
                                                                    false
                                                                )
                                                            }
                                                            aria-label={`Unpin ${
                                                                header.column
                                                                    .columnDef
                                                                    .header as string
                                                            } column`}
                                                            title={`Unpin ${
                                                                header.column
                                                                    .columnDef
                                                                    .header as string
                                                            } column`}
                                                        >
                                                            <PinOffIcon
                                                                className="opacity-60"
                                                                size={16}
                                                                aria-hidden="true"
                                                            />
                                                        </Button>
                                                    ) : (
                                                        <DropdownMenu>
                                                            <DropdownMenuTrigger
                                                                asChild
                                                            >
                                                                <Button
                                                                    size="icon"
                                                                    variant="ghost"
                                                                    className="-mr-1 size-7 shadow-none"
                                                                    aria-label={`Pin options for ${
                                                                        header
                                                                            .column
                                                                            .columnDef
                                                                            .header as string
                                                                    } column`}
                                                                    title={`Pin options for ${
                                                                        header
                                                                            .column
                                                                            .columnDef
                                                                            .header as string
                                                                    } column`}
                                                                >
                                                                    <EllipsisIcon
                                                                        className="opacity-60"
                                                                        size={
                                                                            16
                                                                        }
                                                                        aria-hidden="true"
                                                                    />
                                                                </Button>
                                                            </DropdownMenuTrigger>
                                                            <DropdownMenuContent align="end">
                                                                <DropdownMenuItem
                                                                    onClick={() =>
                                                                        header.column.pin(
                                                                            "left"
                                                                        )
                                                                    }
                                                                >
                                                                    <ArrowLeftToLineIcon
                                                                        size={
                                                                            16
                                                                        }
                                                                        className="opacity-60"
                                                                        aria-hidden="true"
                                                                    />
                                                                    Stick to
                                                                    left
                                                                </DropdownMenuItem>
                                                                <DropdownMenuItem
                                                                    onClick={() =>
                                                                        header.column.pin(
                                                                            "right"
                                                                        )
                                                                    }
                                                                >
                                                                    <ArrowRightToLineIcon
                                                                        size={
                                                                            16
                                                                        }
                                                                        className="opacity-60"
                                                                        aria-hidden="true"
                                                                    />
                                                                    Stick to
                                                                    right
                                                                </DropdownMenuItem>
                                                            </DropdownMenuContent>
                                                        </DropdownMenu>
                                                    ))}
                                                {header.column.getCanResize() && (
                                                    <div
                                                        {...{
                                                            onDoubleClick: () =>
                                                                header.column.resetSize(),
                                                            onMouseDown:
                                                                header.getResizeHandler(),
                                                            onTouchStart:
                                                                header.getResizeHandler(),
                                                            className:
                                                                "absolute top-0 h-full w-4 cursor-col-resize user-select-none touch-none -right-2 z-10 flex justify-center before:absolute before:w-px before:inset-y-0 before:bg-border before:-translate-x-px",
                                                        }}
                                                    />
                                                )}
                                            </div>
                                        </TableHead>
                                    );
                                })}
                            </TableRow>
                        ))}
                    </TableHeader>
                    <TableBody>
                        {table.getRowModel().rows?.length ? (
                            table.getRowModel().rows.map((row) => (
                                <TableRow
                                    key={row.id}
                                    data-state={
                                        row.getIsSelected() && "selected"
                                    }
                                >
                                    {row.getVisibleCells().map((cell) => {
                                        const { column } = cell;
                                        const isPinned = column.getIsPinned();
                                        const isLastLeftPinned =
                                            isPinned === "left" &&
                                            column.getIsLastColumn("left");
                                        const isFirstRightPinned =
                                            isPinned === "right" &&
                                            column.getIsFirstColumn("right");

                                        return (
                                            <TableCell
                                                key={cell.id}
                                                className="[&[data-pinned][data-last-col]]:border-border data-pinned:bg-background/90 truncate data-pinned:backdrop-blur-xs [&[data-pinned=left][data-last-col=left]]:border-r [&[data-pinned=right][data-last-col=right]]:border-l"
                                                style={{
                                                    ...getPinningStyles(column),
                                                }}
                                                data-pinned={
                                                    isPinned || undefined
                                                }
                                                data-last-col={
                                                    isLastLeftPinned
                                                        ? "left"
                                                        : isFirstRightPinned
                                                        ? "right"
                                                        : undefined
                                                }
                                            >
                                                {flexRender(
                                                    cell.column.columnDef.cell,
                                                    cell.getContext()
                                                )}
                                            </TableCell>
                                        );
                                    })}
                                </TableRow>
                            ))
                        ) : (
                            <TableRow>
                                <TableCell
                                    colSpan={columns.length}
                                    className="h-24 text-center"
                                >
                                    No results.
                                </TableCell>
                            </TableRow>
                        )}
                    </TableBody>
                </Table>
            </div>

            {/* Pagination */}
            <div className="flex items-center justify-between gap-8">
                {/* Results per page */}
                <div className="flex items-center gap-3">
                    <Label htmlFor="rows-per-page" className="max-sm:sr-only">
                        Rows per page
                    </Label>
                    <Select
                        value={table.getState().pagination.pageSize.toString()}
                        onValueChange={(value) => {
                            table.setPageSize(Number(value));
                        }}
                    >
                        <SelectTrigger
                            id="rows-per-page"
                            className="w-fit whitespace-nowrap"
                        >
                            <SelectValue placeholder="Select number of results" />
                        </SelectTrigger>
                        <SelectContent className="[&_*[role=option]]:ps-2 [&_*[role=option]]:pe-8 [&_*[role=option]>span]:start-auto [&_*[role=option]>span]:end-2">
                            {[5, 10, 25, 50].map((pageSize) => (
                                <SelectItem
                                    key={pageSize}
                                    value={pageSize.toString()}
                                >
                                    {pageSize}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>
                {/* Page number information */}
                <div className="text-muted-foreground flex grow justify-end text-sm whitespace-nowrap">
                    <p
                        className="text-muted-foreground text-sm whitespace-nowrap"
                        aria-live="polite"
                    >
                        <span className="text-foreground">
                            {table.getState().pagination.pageIndex *
                                table.getState().pagination.pageSize +
                                1}
                            -
                            {Math.min(
                                Math.max(
                                    table.getState().pagination.pageIndex *
                                        table.getState().pagination.pageSize +
                                        table.getState().pagination.pageSize,
                                    0
                                ),
                                table.getRowCount()
                            )}
                        </span>{" "}
                        of{" "}
                        <span className="text-foreground">
                            {table.getRowCount().toString()}
                        </span>
                    </p>
                </div>

                {/* Pagination buttons */}
                <div>
                    <Pagination>
                        <PaginationContent>
                            {/* First page button */}
                            <PaginationItem>
                                <Button
                                    size="icon"
                                    variant="outline"
                                    className="disabled:pointer-events-none disabled:opacity-50"
                                    onClick={() => table.firstPage()}
                                    disabled={!table.getCanPreviousPage()}
                                    aria-label="Go to first page"
                                >
                                    <ChevronFirstIcon
                                        size={16}
                                        aria-hidden="true"
                                    />
                                </Button>
                            </PaginationItem>
                            {/* Previous page button */}
                            <PaginationItem>
                                <Button
                                    size="icon"
                                    variant="outline"
                                    className="disabled:pointer-events-none disabled:opacity-50"
                                    onClick={() => table.previousPage()}
                                    disabled={!table.getCanPreviousPage()}
                                    aria-label="Go to previous page"
                                >
                                    <ChevronLeftIcon
                                        size={16}
                                        aria-hidden="true"
                                    />
                                </Button>
                            </PaginationItem>
                            {/* Next page button */}
                            <PaginationItem>
                                <Button
                                    size="icon"
                                    variant="outline"
                                    className="disabled:pointer-events-none disabled:opacity-50"
                                    onClick={() => table.nextPage()}
                                    disabled={!table.getCanNextPage()}
                                    aria-label="Go to next page"
                                >
                                    <ChevronRightIcon
                                        size={16}
                                        aria-hidden="true"
                                    />
                                </Button>
                            </PaginationItem>
                            {/* Last page button */}
                            <PaginationItem>
                                <Button
                                    size="icon"
                                    variant="outline"
                                    className="disabled:pointer-events-none disabled:opacity-50"
                                    onClick={() => table.lastPage()}
                                    disabled={!table.getCanNextPage()}
                                    aria-label="Go to last page"
                                >
                                    <ChevronLastIcon
                                        size={16}
                                        aria-hidden="true"
                                    />
                                </Button>
                            </PaginationItem>
                        </PaginationContent>
                    </Pagination>
                </div>
            </div>
        </>
    );
}
