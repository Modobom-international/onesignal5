import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { InfoIcon } from "lucide-react";
import {
    Area,
    AreaChart,
    CartesianGrid,
    XAxis,
    YAxis,
    ResponsiveContainer,
    Tooltip,
} from "recharts";

// Generate 24-hour data with timestamps
const generateHourlyData = () => {
    return Array.from({ length: 24 }, (_, i) => {
        const hour = i.toString().padStart(2, "0");
        return {
            time: `${hour}:00`,
            htmlSource: Math.floor(Math.random() * 100) + 20,
            usersTracking: Math.floor(Math.random() * 80) + 10,
        };
    });
};

// Queue metrics data
const queueMetrics = {
    create_html_source: {
        length: 0,
        runtime: 0,
        processes: 1,
    },
    create_users_tracking: {
        length: 0,
        runtime: 0,
        processes: 1,
    },
};

export default function DashboardPage() {
    const data = generateHourlyData();

    return (
        <AuthenticatedLayout title="Dashboard">
            {/* Header Section */}
            <div className="">
                <div className="border-b border-gray-200 pb-5 mb-8">
                    <h1 className="text-3xl font-bold tracking-tight text-gray-900">
                        Dashboard
                    </h1>
                    <p className="mt-2 text-sm text-gray-600">
                        Welcome back, Admin
                    </p>
                </div>

                {/* Queue Metrics Section */}
                <div className="mb-12">
                    <h2 className="text-xl font-semibold text-gray-900 mb-6">
                        Queue Metrics
                    </h2>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {/* HTML Source Queue Card */}
                        <div className="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
                            <div className="flex items-center justify-between mb-4">
                                <h3 className="text-base font-medium text-gray-900">
                                    HTML Source Queue
                                </h3>
                                <button className="text-gray-400 hover:text-gray-600 transition-colors p-1 hover:bg-gray-50 rounded-full">
                                    <InfoIcon className="w-4 h-4" />
                                </button>
                            </div>
                            <div className="space-y-2">
                                <div className="flex items-baseline gap-2">
                                    <span className="text-3xl font-bold text-gray-900">
                                        {queueMetrics.create_html_source.length}
                                    </span>
                                    <span className="text-sm font-medium text-gray-500">
                                        Jobs in queue
                                    </span>
                                </div>
                                <p className="text-sm text-gray-500">
                                    Runtime:{" "}
                                    {queueMetrics.create_html_source.runtime}ms
                                </p>
                            </div>
                        </div>

                        {/* Users Tracking Queue Card */}
                        <div className="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
                            <div className="flex items-center justify-between mb-4">
                                <h3 className="text-base font-medium text-gray-900">
                                    Users Tracking Queue
                                </h3>
                                <button className="text-gray-400 hover:text-gray-600 transition-colors p-1 hover:bg-gray-50 rounded-full">
                                    <InfoIcon className="w-4 h-4" />
                                </button>
                            </div>
                            <div className="space-y-2">
                                <div className="flex items-baseline gap-2">
                                    <span className="text-3xl font-bold text-gray-900">
                                        {
                                            queueMetrics.create_users_tracking
                                                .length
                                        }
                                    </span>
                                    <span className="text-sm font-medium text-gray-500">
                                        Jobs in queue
                                    </span>
                                </div>
                                <p className="text-sm text-gray-500">
                                    Runtime:{" "}
                                    {queueMetrics.create_users_tracking.runtime}
                                    ms
                                </p>
                            </div>
                        </div>

                        {/* Active Processes Card */}
                        <div className="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all">
                            <div className="flex items-center justify-between mb-4">
                                <h3 className="text-base font-medium text-gray-900">
                                    Active Processes
                                </h3>
                                <button className="text-gray-400 hover:text-gray-600 transition-colors p-1 hover:bg-gray-50 rounded-full">
                                    <InfoIcon className="w-4 h-4" />
                                </button>
                            </div>
                            <div className="space-y-2">
                                <div className="flex items-baseline gap-2">
                                    <span className="text-3xl font-bold text-gray-900">
                                        {queueMetrics.create_html_source
                                            .processes +
                                            queueMetrics.create_users_tracking
                                                .processes}
                                    </span>
                                    <span className="text-sm font-medium text-gray-500">
                                        Total processes
                                    </span>
                                </div>
                                <p className="text-sm text-gray-500">
                                    HTML:{" "}
                                    {queueMetrics.create_html_source.processes}{" "}
                                    | Users:{" "}
                                    {
                                        queueMetrics.create_users_tracking
                                            .processes
                                    }
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Queue Overview Section */}
                <div className="mb-12">
                    <h2 className="text-xl font-semibold text-gray-900 mb-6">
                        Queue Overview
                    </h2>

                    <div className="bg-white">
                        <ResponsiveContainer width="100%" height={450}>
                            <AreaChart
                                data={data}
                                margin={{
                                    top: 20,
                                    right: 30,
                                    left: 10,
                                    bottom: 20,
                                }}
                            >
                                <defs>
                                    <linearGradient
                                        id="htmlSourceGradient"
                                        x1="0"
                                        y1="0"
                                        x2="0"
                                        y2="1"
                                    >
                                        <stop
                                            offset="5%"
                                            stopColor="#0EA5E9"
                                            stopOpacity={0.15}
                                        />
                                        <stop
                                            offset="95%"
                                            stopColor="#0EA5E9"
                                            stopOpacity={0.01}
                                        />
                                    </linearGradient>
                                    <linearGradient
                                        id="usersTrackingGradient"
                                        x1="0"
                                        y1="0"
                                        x2="0"
                                        y2="1"
                                    >
                                        <stop
                                            offset="5%"
                                            stopColor="#8B5CF6"
                                            stopOpacity={0.15}
                                        />
                                        <stop
                                            offset="95%"
                                            stopColor="#8B5CF6"
                                            stopOpacity={0.01}
                                        />
                                    </linearGradient>
                                </defs>
                                <XAxis
                                    dataKey="time"
                                    stroke="#94A3B8"
                                    fontSize={13}
                                    tickLine={false}
                                    axisLine={false}
                                    dy={10}
                                />
                                <YAxis
                                    stroke="#94A3B8"
                                    fontSize={13}
                                    tickLine={false}
                                    axisLine={false}
                                    tickFormatter={(value) => `${value}`}
                                    dx={-10}
                                />
                                <CartesianGrid
                                    stroke="#E2E8F0"
                                    strokeDasharray="3 3"
                                    vertical={false}
                                />
                                <Tooltip
                                    contentStyle={{
                                        backgroundColor: "white",
                                        border: "none",
                                        borderRadius: "12px",
                                        padding: "16px",
                                        boxShadow:
                                            "0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)",
                                    }}
                                    itemStyle={{
                                        color: "#64748B",
                                        fontSize: "14px",
                                        padding: "4px 0",
                                    }}
                                    labelStyle={{
                                        color: "#0F172A",
                                        fontWeight: "600",
                                        fontSize: "14px",
                                        marginBottom: "8px",
                                    }}
                                />
                                <Area
                                    type="monotone"
                                    dataKey="htmlSource"
                                    name="HTML Source"
                                    stroke="#0EA5E9"
                                    fill="url(#htmlSourceGradient)"
                                    strokeWidth={2}
                                />
                                <Area
                                    type="monotone"
                                    dataKey="usersTracking"
                                    name="Users Tracking"
                                    stroke="#8B5CF6"
                                    fill="url(#usersTrackingGradient)"
                                    strokeWidth={2}
                                />
                            </AreaChart>
                        </ResponsiveContainer>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
