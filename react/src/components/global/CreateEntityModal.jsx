import { useState, useEffect } from "react";
import { Link } from "react-router-dom";

function CreateEntityModal({
    isOpen,
    onClose,
    onSubmit,
    fields,
    entityData,
    onDelete,
    modalMode,
}) {
    const [formData, setFormData] = useState(entityData || {});

    useEffect(() => {
        setFormData({ ...entityData });
    }, [entityData]);

    const handleInputChange = (e) => {
        const { name, options, type } = e.target;

        if (type === "select-multiple") {
            // Handle multiple selection fields
            const selectedValues = Array.from(options)
                .filter((option) => option.selected)
                .map((option) => option.value);
            setFormData({ ...formData, [name]: selectedValues });
        } else {
            // Handle single value fields
            const value =
                type === "select-one" ? e.target.value : e.target.checked;
            setFormData({ ...formData, [name]: value });
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(e, formData);
        onClose();
    };

    const handleDelete = (e) => {
        e.preventDefault();
        onDelete(e, formData);
        onClose();
    };

    const renderField = (field) => {
        if (field.type === "select" && field.options) {
            return (
                <select
                    id={field.name}
                    name={field.name}
                    value={
                        formData[field.name] ||
                        (field.multiple ? formData.selected_ids : "")
                    }
                    onChange={handleInputChange}
                    multiple={field.multiple}
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

    const renderFormFields = (fields) => {
        return fields.map((field) => (
            <div key={field.name} className="mb-4">
                <label htmlFor={field.name}>{field.label}:</label>
                {renderField(field)}
            </div>
        ));
    };

    if (!isOpen) {
        return null;
    }

    return (
        <div className="fixed inset-0 flex items-center justify-center z-50">
            <div className="modal-overlay fixed inset-0 bg-black opacity-50"></div>
            <div className="modal-container bg-white w-96 mx-auto rounded shadow-lg z-50 p-4">
                <span
                    className="modal-close cursor-pointer absolute top-2 right-2 text-gray-600 text-7xl text-white"
                    onClick={onClose}
                >
                    &times;
                </span>

                <h2 className="text-2xl mb-4">
                    {modalMode === "edit"
                        ? `Edit ${formData.name}`
                        : "Create Component"}
                </h2>
                <form onSubmit={handleSubmit}>
                    {renderFormFields(fields)}
                    <div className="flex gap-x-4">
                        <button
                            type="submit"
                            className="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            {modalMode === "edit" ? "Update" : "Create"}
                        </button>
                        {modalMode === "edit" && (
                            <button
                                type="button"
                                onClick={handleDelete}
                                className="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            >
                                Delete
                            </button>
                        )}
                        <Link
                            to={`./${formData.id}`}
                            className="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            View Details
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    );
}

export default CreateEntityModal;
