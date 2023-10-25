const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
};

export const renderField = (field, formData) => {
    if (field.type === "select" && field.options) {
        return (
            <select
                id={field.name}
                name={field.name}
                value={formData[field.name] || ""}
                onChange={handleInputChange}
                className="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
                <option value="">{`Select ${field.label}`}</option>
                {field.options.map((option) => (
                    <option key={option.value} value={option.value}>
                        {option.label}
                    </option>
                ))}
            </select>
        );
    } else {
        return (
            <input
                id={field.name}
                name={field.name}
                type={field.type}
                value={formData[field.name] || ""}
                className="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder={`Enter ${field.label}`}
                onChange={handleInputChange}
            />
        );
    }
};
