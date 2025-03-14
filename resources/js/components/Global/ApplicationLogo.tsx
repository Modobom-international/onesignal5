import { cn } from "@/lib/utils";

interface Props {
    isDarkMode: boolean;
    className?: string;
}

export default function ApplicationLogo({ isDarkMode, className }: Props) {
    return (
        <img
            src={
                isDarkMode
                    ? "/img/logo-modobom-resize.png"
                    : "/img/logo-modobom-resize-dark.png"
            }
            alt="Logo"
            className={cn(className)}
        />
    );
}
