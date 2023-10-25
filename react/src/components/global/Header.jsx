import CreateEntityModal from "./CreateEntityModal";
import { useState } from "react";

function Header({ title, fields, onSubmit }) {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleAddNewClick = () => {
        setIsModalOpen(true);
    };

    return (
        <div className="py-6 flex justify-between">
            <h1 className="text-2xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                {title}
            </h1>
            <button
                onClick={() => {
                    handleAddNewClick();
                }}
                className="bg-green-500 p-4 rounded-full text-white"
            >
                Add New
            </button>
            <CreateEntityModal
                isOpen={isModalOpen}
                onClose={() => setIsModalOpen(false)}
                onSubmit={onSubmit}
                fields={fields}
            />
        </div>
    );
}

export default Header;
