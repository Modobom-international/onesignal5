import AppLayout from "@/Layouts/AppLayout";

export default function Home() {
    return (
        <AppLayout title="Home">
            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div className="p-6 text-gray-900">
                    Welcome to your React-powered Laravel application!
                </div>
            </div>
        </AppLayout>
    );
}
