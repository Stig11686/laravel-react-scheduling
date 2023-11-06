import {
    Bars3Icon,
    BellIcon,
    CalendarIcon,
    ChartPieIcon,
    Cog6ToothIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    XMarkIcon,
} from "@heroicons/react/24/outline";

function Navigation() {
    const navigation = [
        { name: "Dashboard", href: "#", icon: HomeIcon, current: true },
        { name: "Courses", href: "/courses", icon: UsersIcon, current: false },
        { name: "Cohorts", href: "/cohorts", icon: FolderIcon, current: false },
        {
            name: "Sessions",
            href: "/sessions",
            icon: CalendarIcon,
            current: false,
        },
        { name: "Users", href: "/users", icon: UsersIcon, current: false },
        {
            name: "Schedule",
            href: "/schedule",
            icon: CalendarIcon,
            current: false,
        },
    ];

    return (
        <nav className="flex flex-1 flex-col">
            <ul role="list" className="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" className="-mx-2 space-y-1">
                        {navigation.map((item) => (
                            <li key={item.name}>
                                <a
                                    href={item.href}
                                    className={classNames(
                                        item.current
                                            ? "bg-gray-800 text-white"
                                            : "text-gray-400 hover:text-white hover:bg-gray-800",
                                        "group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"
                                    )}
                                >
                                    <item.icon
                                        className="h-6 w-6 shrink-0"
                                        aria-hidden="true"
                                    />
                                    {item.name}
                                </a>
                            </li>
                        ))}
                    </ul>
                </li>
                <li className="mt-auto">
                    <a
                        href="#"
                        className="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-400 hover:bg-gray-800 hover:text-white"
                    >
                        <Cog6ToothIcon
                            className="h-6 w-6 shrink-0"
                            aria-hidden="true"
                        />
                        Settings
                    </a>
                </li>
            </ul>
        </nav>
    );
}

export default Navigation;
