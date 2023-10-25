import useDataFetching from "../../hooks/useDataFetching";
import Table from "./Table";
import Header from "../global/Header";
import Loader from "./Loader";
import PaginationComponent from "./PaginationComponent";
import Message from "./Message";
import CreateEntityModal from "./CreateEntityModal";
import axios from "../../../axios";
import { useState } from "react";

function DataFetchingComponent({
    endpoint,
    title,
    createEntityFields,
    selectedFields,
}) {
    const [page, setPage] = useState(1);
    const { data, setData, error, loading, pagination } = useDataFetching(
        endpoint,
        page
    );
    const [message, setMessage] = useState(null);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [modalMode, setModalMode] = useState("create"); // Default to create mode
    const [modalData, setModalData] = useState(null);

    const openModal = (mode, data = null) => {
        setIsModalOpen(true);
        setModalMode(mode);
        setModalData(data);
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setModalMode("create");
        setModalData(null);
    };

    const handlePageChange = (newPage) => {
        setPage(newPage);
    };

    const onDelete = async (e, formData) => {
        e.preventDefault();
        try {
            axios
                .delete(`${endpoint}/${formData.id}`, formData, {
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                .then((resp) => {
                    console.log(resp);
                    setMessage({
                        message: resp.data.message,
                        type: "success",
                    });
                    setData(resp.data.data);
                });
        } catch (error) {
            console.log(error);
            const { errors } = error.response.data;

            if (!errors) {
                setMessage({ errors: error.message, type: "error" });
            } else {
                console.log(errors);
                setMessage({ ...errors, type: "error" });
            }
        }
    };

    const createEntity = async (e, formData) => {
        e.preventDefault();
        // Send a POST request to your API endpoint to create a new course
        try {
            const response = await axios
                .post(endpoint, formData, {
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                .then((resp) => {
                    setMessage({
                        message: resp.data.message,
                        type: "success",
                    });

                    setData([...data, resp.data.data]);
                });
        } catch (error) {
            const { errors } = error.response.data;

            if (!errors) {
                setMessage({ errors: error.message, type: "error" });
            } else {
                console.log(errors);
                setMessage({ ...errors, type: "error" });
            }
        }
    };

    if (loading) {
        return <Loader />;
    }

    if (error) {
        return <p>Error: {error}</p>;
    }

    return (
        <>
            <Header
                title={title}
                onSubmit={createEntity}
                fields={createEntityFields}
                onAddNew={() => openModal("create")}
            />
            {message && <Message message={message} />}
            <Table
                data={data}
                baseUrl={endpoint}
                onRowClick={(data) => openModal("edit", data)}
            />
            <CreateEntityModal
                isOpen={isModalOpen}
                onClose={closeModal}
                modalMode={modalMode}
                entityData={modalData}
                fields={createEntityFields}
                selectedFields={selectedFields}
                onDelete={onDelete}
            />
            {pagination && (
                <PaginationComponent
                    onPageChange={handlePageChange}
                    currentPage={pagination.current_page}
                    lastPage={pagination.last_page}
                />
            )}
        </>
    );
}

export default DataFetchingComponent;
