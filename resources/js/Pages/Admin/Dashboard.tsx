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
            <div className="container mx-auto py-10">
                {/* Queue Metrics Section */}
                <div className="mb-16">
                    <h2 className="text-xl font-bold text-gray-900 mb-10 pb-4 border-b border-border">
                        Queue Metrics
                    </h2>
                    <div className="grid grid-cols-3 gap-x-12">
                        {/* HTML Source Queue */}
                        <div className="space-y-3">
                            <div className="flex items-center gap-2">
                                <h3 className="text-base font-semibold text-gray-700">
                                    HTML Source Queue
                                </h3>
                                <button className="text-gray-400 hover:text-gray-600 transition-colors">
                                    <InfoIcon className="w-4 h-4" />
                                </button>
                            </div>
                            <div className="flex items-baseline gap-3">
                                <span className="text-2xl font-bold text-gray-900">
                                    {queueMetrics.create_html_source.length}
                                </span>
                                <span className="text-base text-gray-600">
                                    Jobs in queue
                                </span>
                            </div>
                            <p className="text-sm text-gray-500">
                                Runtime:{" "}
                                {queueMetrics.create_html_source.runtime}ms
                            </p>
                        </div>

                        {/* Users Tracking Queue */}
                        <div className="space-y-3">
                            <div className="flex items-center gap-2">
                                <h3 className="text-base font-semibold text-gray-700">
                                    Users Tracking Queue
                                </h3>
                                <button className="text-gray-400 hover:text-gray-600 transition-colors">
                                    <InfoIcon className="w-4 h-4" />
                                </button>
                            </div>
                            <div className="flex items-baseline gap-3">
                                <span className="text-2xl font-bold text-gray-900">
                                    {queueMetrics.create_users_tracking.length}
                                </span>
                                <span className="text-base text-gray-600">
                                    Jobs in queue
                                </span>
                            </div>
                            <p className="text-sm text-gray-500">
                                Runtime:{" "}
                                {queueMetrics.create_users_tracking.runtime}ms
                            </p>
                        </div>

                        {/* Active Processes */}
                        <div className="space-y-3">
                            <div className="flex items-center gap-2">
                                <h3 className="text-base font-semibold text-gray-700">
                                    Active Processes
                                </h3>
                            </div>
                            <div className="flex items-baseline gap-3">
                                <span className="text-2xl font-bold text-gray-900">
                                    {queueMetrics.create_html_source.processes +
                                        queueMetrics.create_users_tracking
                                            .processes}
                                </span>
                                <span className="text-base text-gray-600">
                                    Total processes
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Queue Overview Section */}
                <div>
                    <div className="mb-10">
                        <h2 className="text-xl font-bold text-gray-900 mb-3 pb-4 border-b border-border">
                            Queue Overview
                        </h2>
                    </div>

                    <div className="grid grid-cols-2 gap-x-12 mb-8">
                        <div>
                            <div className="flex items-center gap-2 mb-6">
                                <h3 className="text-base font-semibold text-gray-700">
                                    HTML Source Throughput
                                </h3>
                                <button className="text-gray-400 hover:text-gray-600 transition-colors">
                                    <InfoIcon className="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                        <div>
                            <div className="flex items-center gap-2 mb-6">
                                <h3 className="text-base font-semibold text-gray-700">
                                    Users Tracking Throughput
                                </h3>
                                <button className="text-gray-400 hover:text-gray-600 transition-colors">
                                    <InfoIcon className="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <div className="h-[450px] w-full bg-white rounded-lg shadow-sm p-4">
                        <ResponsiveContainer width="100%" height="100%">
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
                                        border: "1px solid #E2E8F0",
                                        borderRadius: "8px",
                                        padding: "12px 16px",
                                        boxShadow: "0 2px 4px rgba(0,0,0,0.05)",
                                    }}
                                    itemStyle={{
                                        color: "#64748B",
                                        fontSize: "14px",
                                        padding: "4px 0",
                                    }}
                                    labelStyle={{
                                        color: "#1E293B",
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
