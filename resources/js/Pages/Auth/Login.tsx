import { LoginForm } from "@/components/Form/Auth/LoginForm";
import ApplicationLogo from "@/components/Global/ApplicationLogo";
import GuestLayout from "@/layouts/GuestLayout";
import { Link, useForm } from "@inertiajs/react";
import { useLaravelReactI18n } from "laravel-react-i18n";
import { FormEventHandler, useEffect } from "react";

export default function Login() {
    const { t } = useLaravelReactI18n();
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: false as const,
    });

    useEffect(() => {
        return () => {
            reset();
        };
    }, []);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route("login"));
    };

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
