import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import EditForm from "../components/global/EditForm";
import Loader from "../components/global/Loader";
import axios from "../../axios";

function Task() {
    const [taskData, setTaskData] = useState(null);
    const [error, setError] = useState("");
    const [isLoading, setIsLoading] = useState(true);

    const { id } = useParams();

    useEffect(
        function () {
            async function fetchTasks() {
                try {
                    axios
                        .get(`/tasks/${id}`, {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then((res) => setTaskData(res.data.data));
                    setIsLoading(false);
                } catch (error) {
                    setError(error);
                }
            }
            fetchTasks();
        },
        [id]
    );
    return (
        <div>
            {error && <p>{error}</p>}
            {isLoading && <Loader />}
            {taskData && (
                <div>
                    <h2 className="text-base font-semibold leading-7 text-gray-900">
                        Edit {taskData.name}
                    </h2>
                    <EditForm task={taskData} handleChange={setTaskData} />
                </div>
            )}
        </div>
    );
}

export default Task;
