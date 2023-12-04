import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import EditForm from "../components/global/EditForm";
import Loader from "../components/global/Loader";
import axios from "../../axios";

function Employer() {
    const [employerData, setEmployerData] = useState(null);
    const [error, setError] = useState("");
    const [isLoading, setIsLoading] = useState(true);

    const { id } = useParams();

    useEffect(
        function () {
            async function fetchEmployer() {
                try {
                    axios
                        .get(`/employers/${id}`, {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then((res) => setEmployerData(res.data.data));
                    setIsLoading(false);
                } catch (error) {
                    setError(error);
                }
            }
            fetchEmployer();
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
                        Edit {employerData.name}
                    </h2>
                    <EditForm
                        task={employerData}
                        handleChange={setEmployerData}
                    />
                </div>
            )}
        </div>
    );
}

export default Employer;
