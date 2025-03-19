"use client";

import { useState, useEffect } from "react";
import { ChevronUp } from "lucide-react";
import { cn } from "@/lib/utils";

export default function ScrollToTop() {
    const [isVisible, setIsVisible] = useState(false);

    const toggleVisibility = () => {
        if (window.scrollY > 300) {
            setIsVisible(true);
        } else {
            setIsVisible(false);
        }
    };

    const scrollToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    };

    useEffect(() => {
        // Add scroll event listener
        window.addEventListener("scroll", toggleVisibility);

        // Clean up the event listener on component unmount
        return () => {
            window.removeEventListener("scroll", toggleVisibility);
        };
    }, []);

    return (
        <button
            onClick={scrollToTop}
            className={cn(
                "fixed bottom-6 right-6 p-3 rounded-full bg-primary text-primary-foreground shadow-lg transition-all duration-300 z-50",
                "hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2",
                isVisible
                    ? "opacity-100 translate-y-0"
                    : "opacity-0 translate-y-10 pointer-events-none"
            )}
            aria-label="Scroll to top"
        >
            <ChevronUp className="h-5 w-5" />
        </button>
    );
}
