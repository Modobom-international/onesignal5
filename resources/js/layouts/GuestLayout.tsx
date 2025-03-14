// import ApplicationLogo from '@/Components/ApplicationLogo';
import { Head } from "@inertiajs/react";
import { PropsWithChildren } from "react";

interface Props {
    title: string;
}

export default function GuestLayout({
    title,
    children,
}: PropsWithChildren<Props>) {
    return (
        <>
            <Head title={title} />
            <main>{children}</main>
        </>
    );
}
