import { PropsWithChildren } from "react";
import { Head } from "@inertiajs/react";

interface Props {
    title: string;
}

export default function AppLayout({
    title,
    children,
}: PropsWithChildren<Props>) {
    return (
        <>
            <Head title={title} />

            <div className="min-h-screen bg-gray-100">
                <main className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        {children}
                    </div>
                </main>
            </div>
        </>
    );
}
