import { LoginForm } from "@/components/Form/Auth/LoginForm";
import ApplicationLogo from "@/components/Global/ApplicationLogo";
import GuestLayout from "@/layouts/GuestLayout";
import { Link } from "@inertiajs/react";

export default function Login() {
    return (
        <GuestLayout title="Login">
            <div className="flex min-h-svh flex-col items-center justify-center gap-6 bg-muted p-6 md:p-10">
                <div className="flex w-full max-w-sm flex-col gap-6">
                    <Link
                        href="/"
                        className="flex items-center gap-2 self-center font-medium"
                    >
                        <ApplicationLogo isDarkMode={false} />
                    </Link>
                    <LoginForm />
                </div>
            </div>
        </GuestLayout>
    );
}
