"use client";

import { Button } from "@/components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
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
    EllipsisIcon,
    PinOffIcon,
    ChevronUpIcon,
    ChevronDownIcon,
} from "lucide-react";
import { CSSProperties, useEffect, useState } from "react";
import { cn } from "@/lib/utils";

type Item = {
    id: string;
    name: string;
    email: string;
    team: string;
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
    };
};

const columns: ColumnDef<Item>[] = [
    {
        header: "Name",
        accessorKey: "name",
        cell: ({ row }) => (
            <div className="truncate font-medium">{row.getValue("name")}</div>
        ),
        enableSorting: true,
    },
    {
        header: "Email",
        accessorKey: "email",
        enableSorting: true,
    },
    {
        header: "Team",
        accessorKey: "team",
        enableSorting: true,
    },
    {
        header: "Actions",
        id: "actions",
        enableSorting: false,
        cell: ({ row }) => {
            return (
                <div className="flex items-center justify-end gap-2">
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="ghost" className="h-8 w-8 p-0">
                                <EllipsisIcon className="h-4 w-4" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            <DropdownMenuItem
                                onClick={() =>
                                    console.log("Edit", row.original.id)
                                }
                            >
                                Edit
                            </DropdownMenuItem>
                            <DropdownMenuItem
                                className="text-red-600"
                                onClick={() =>
                                    console.log("Delete", row.original.id)
                                }
                            >
                                Delete
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            );
        },
    },
];

export default function UserDataTable() {
    const [data] = useState<Item[]>([
        {
            id: "1",
            name: "John Doe",
            email: "john.doe@example.com",
            team: "Engineering",
        },
        {
            id: "2",
            name: "Jane Smith",
            email: "jane.smith@example.com",
            team: "Design",
        },
        {
            id: "3",
            name: "Michael Johnson",
            email: "michael.j@example.com",
            team: "Marketing",
        },
        {
            id: "4",
            name: "Sarah Williams",
            email: "sarah.w@example.com",
            team: "Sales",
        },
        {
            id: "5",
            name: "David Chen",
            email: "david.chen@example.com",
            team: "Finance",
        },
    ]);
    const [sorting, setSorting] = useState<SortingState>([]);

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
        <div className="w-full">
            <Table className="w-full [&_td]:border-border [&_th]:border-border border-separate border-spacing-0 [&_tfoot_td]:border-t [&_th]:border-b [&_tr]:border-none [&_tr:not(:last-child)_td]:border-b">
                <TableHeader>
                    {table.getHeaderGroups().map((headerGroup) => (
                        <TableRow key={headerGroup.id} className="bg-muted/50">
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
                                        style={{ ...getPinningStyles(column) }}
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
                                        <div className="flex items-center justify-between gap-2">
                                            {!header.isPlaceholder && (
                                                <div
                                                    className={cn(
                                                        "flex items-center gap-2",
                                                        header.column.getCanSort() &&
                                                            "cursor-pointer select-none"
                                                    )}
                                                    onClick={header.column.getToggleSortingHandler()}
                                                    onKeyDown={(e) => {
                                                        if (
                                                            header.column.getCanSort() &&
                                                            (e.key ===
                                                                "Enter" ||
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
                                                    <span className="truncate">
                                                        {flexRender(
                                                            header.column
                                                                .columnDef
                                                                .header,
                                                            header.getContext()
                                                        )}
                                                    </span>
                                                    {{
                                                        asc: (
                                                            <ChevronUpIcon
                                                                className="shrink-0 opacity-60"
                                                                size={16}
                                                            />
                                                        ),
                                                        desc: (
                                                            <ChevronDownIcon
                                                                className="shrink-0 opacity-60"
                                                                size={16}
                                                            />
                                                        ),
                                                    }[
                                                        header.column.getIsSorted() as string
                                                    ] ?? null}
                                                </div>
                                            )}
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
                                                                    size={16}
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
                                                                    size={16}
                                                                    className="opacity-60"
                                                                    aria-hidden="true"
                                                                />
                                                                Stick to left
                                                            </DropdownMenuItem>
                                                            <DropdownMenuItem
                                                                onClick={() =>
                                                                    header.column.pin(
                                                                        "right"
                                                                    )
                                                                }
                                                            >
                                                                <ArrowRightToLineIcon
                                                                    size={16}
                                                                    className="opacity-60"
                                                                    aria-hidden="true"
                                                                />
                                                                Stick to right
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
                                data-state={row.getIsSelected() && "selected"}
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
                                            data-pinned={isPinned || undefined}
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
    );
}
