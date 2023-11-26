import { useStateContext } from "../../contexts/ContextProvider";

function generateColumns(data) {
    const dataArray = Array.isArray(data) ? data : [data];

    if (!dataArray || dataArray.length === 0) {
        return [];
    }

    const firstItem = dataArray[0];
    const columns = [];

    for (const [key, value] of Object.entries(firstItem)) {
        let type = typeof value;

        // Check for specific types
        if (type === "object") {
            if (Array.isArray(value)) {
                type = "array";
            } else if (value instanceof Date) {
                type = "date";
            }
        } else {
            type = "string";
        }

        if (key !== "id" && !key.endsWith("_id")) {
            columns.push({ name: key, type });
        }
    }

    return columns;
}

function isDate(value) {
    return (
        /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/.test(value) ||
        /^\d{4}-\d{2}-\d{2}$/.test(value)
    );
}

function formatData(column, value) {
    if (column.type === "string" && isDate(value)) {
        // Parse the date string to create a Date object
        const [year, month, day] = value.split("-");
        const parsedDate = new Date(
            parseInt(year, 10),
            parseInt(month, 10) - 1,
            parseInt(day, 10)
        );

        // Check if parsedDate is a valid Date object
        if (!isNaN(parsedDate.getTime())) {
            // Format date as d-m-Y
            const options = {
                day: "numeric",
                month: "numeric",
                year: "numeric",
            };
            return parsedDate.toLocaleDateString(undefined, options);
        }
    } else if (column.type === "array") {
        if (Array.isArray(value)) {
            return String(value.length);
        } else {
            return "0";
        }
    } else if (column.type === "string") {
        // Return the string as is
        return value;
    } else {
        // Fallback: return value as string representation
        return String(value);
    }
}

function formatHeadings(inputString) {
    // Use regular expression to replace underscores and dashes with spaces
    const modifiedString = inputString.replace(/[_-]/g, " ");
    return modifiedString;
}

function Table({ data, onRowClick }) {
    const { user } = useStateContext();

    if (!data || data.length === 0) {
        return <p>No data available</p>;
    }

    function handleRowClick(rowData) {
        if (onRowClick) {
            onRowClick(rowData);
        }
    }

    const columns = generateColumns(data);

    return (
        <div className="overflow-x-auto">
            <table className="min-w-full text-center">
                <thead>
                    <tr>
                        {columns.map((column) => (
                            <th
                                key={column.name}
                                className="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                {formatHeadings(column.name)}
                            </th>
                        ))}
                    </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                    {data.map((item) => (
                        <tr
                            className={"cursor-pointer"}
                            key={item.id}
                            onClick={() => handleRowClick(item)}
                        >
                            {columns.map((column) => (
                                <td
                                    key={column.name}
                                    className={`${
                                        item[column.name] === null
                                            ? "bg-red-200"
                                            : ""
                                    } px-6 py-4 whitespace-nowrap`}
                                >
                                    {formatData(column, item[column.name])}
                                </td>
                            ))}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

export default Table;
