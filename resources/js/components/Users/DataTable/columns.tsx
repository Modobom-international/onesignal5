"use client";

import { ColumnDef } from "@tanstack/react-table";

// This type is used to define the shape of our data.
// You can use a Zod schema here if you want.
export type UserColumn = {
    id: string;
    name: string;
    email: string;
    team: string;
};

export const columns: ColumnDef<UserColumn>[] = [
    {
        accessorKey: "id",
        header: "ID",
        // Hide this column by default as it's usually not needed in the UI
        enableHiding: true,
        enableSorting: false,
    },
    {
        accessorKey: "name",
        header: "Name",
    },
    {
        accessorKey: "email",
        header: "Email",
    },
    {
        accessorKey: "team",
        header: "Team",
    },
];
