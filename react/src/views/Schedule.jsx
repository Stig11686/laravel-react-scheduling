import { useState } from "react";
import useDataFetching from "../hooks/useDataFetching";
import ScheduleAccordion from "../components/global/ScheduleAccordion";
import Table from "../components/global/Table";
import Loader from "../components/global/Loader";
import Header from "../components/global/Header";
import PaginationComponent from "../components/global/PaginationComponent";
import CreateEntityModal from "../components/global/CreateEntityModal";
import axios from "../../axios";
import { useStateContext } from "../contexts/ContextProvider";

function Schedule() {
    const { user } = useStateContext();

    const { data, error, loading, pagination, setData } = useDataFetching(
        "/schedule",
        1,
        user.id
    );
    const { data: sessions } = useDataFetching("/sessions");
    const { data: trainers } = useDataFetching("/trainers");
    const { data: zoom_rooms } = useDataFetching("/zoom_rooms");
    const { data: cohorts } = useDataFetching("/cohorts");
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [modalMode, setModalMode] = useState("create"); // Default to create mode
    const [modalData, setModalData] = useState(null);
    const [message, setMessage] = useState(null);

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

    const onDelete = async (e, formData) => {
        e.preventDefault();
        console.log(formData);
        try {
            axios
                .delete(`cohort_session/${formData.id}`, formData, {
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

    const handleSubmit = async (e, formData) => {
        let apiMethod = "post"; // Default to POST request
        let apiEndpoint = "/schedule";

        if (modalMode === "edit") {
            apiMethod = "put";
            apiEndpoint += `/${formData.id}`;
        }

        try {
            const response = await axios[apiMethod](apiEndpoint, formData, {
                headers: {
                    "Content-Type": "application/json",
                },
            });

            setMessage({
                message: response.data.message,
                type: "success",
            });

            if (modalMode === "edit") {
                // If in edit mode, update the specific item in the data array
                setData(response.data.data);
            } else {
                // If in create mode, add the new item to the data array
                setData((prevData) => [...prevData, response.data.data]);
            }
        } catch (error) {
            console.log(error);
            // const { errors } = error.response.data;

            // if (!errors) {
            //     setMessage({ errors: error.message, type: "error" });
            // } else {
            //     console.log(errors);
            //     setMessage({ ...errors, type: "error" });
            // }
        }
    };

    const fields = [
        {
            name: "cohort_id",
            label: "Cohort",
            type: "select",
            options: cohorts.map((cohort) => ({
                label: cohort.name,
                value: cohort.id,
            })),
        },
        {
            name: "session_id",
            label: "Session Name",
            type: "select",
            options: sessions.map((session) => ({
                label: session.name,
                value: session.id,
            })),
        },
        {
            name: "date",
            type: "date",
            label: "Date",
        },
        {
            name: "zoom_room_id",
            type: "select",
            options: zoom_rooms.map((room) => ({
                label: room.name,
                value: room.id,
            })),
            label: "Zoom Room",
        },
        {
            name: "trainer_id",
            type: "select",
            options: trainers.map((trainer) => ({
                label: trainer.name,
                value: trainer.id,
            })),
            label: "Trainer",
        },
    ];

    return error ? (
        <p>Error here</p>
    ) : loading ? (
        <Loader />
    ) : (
        <>
            <Header title="Schedule" fields={fields} />
            {data.map((item) => (
                <ScheduleAccordion
                    key={item.id}
                    course={item.course_name}
                    cohort={item.cohort_name}
                >
                    <Table
                        data={item.sessions}
                        key={item.cohort_name}
                        onRowClick={(item) => openModal("edit", item)}
                    />
                </ScheduleAccordion>
            ))}
            {pagination && <PaginationComponent />}

            <CreateEntityModal
                isOpen={isModalOpen}
                onClose={closeModal}
                onSubmit={handleSubmit}
                fields={fields}
                onDelete={onDelete}
                modalMode={modalMode}
                entityData={modalData}
            />
        </>
    );
}

export default Schedule;
