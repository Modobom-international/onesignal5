import ApplicationLogo from "@/components/Global/ApplicationLogo";
import FeaturesSection from "@/components/Home/FeaturesSection";
import Footer from "@/components/Home/Footer";
import Header from "@/components/Home/Header";
import HeroSection from "@/components/Home/HeroSection";
import GuestLayout from "@/layouts/GuestLayout";

export default function Home() {
    return (
        <GuestLayout title="Home">
            <Header />
            <HeroSection />
            <FeaturesSection />
            <Footer />
        </GuestLayout>
    );
}
