import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import EditForm from "../components/global/EditForm";
import Loader from "../components/global/Loader";
import axios from "../../axios";

function Session() {
    const [courseData, setCourseData] = useState(null);
    const [error, setError] = useState("");
    const [isLoading, setIsLoading] = useState(true);

    const { id } = useParams();

    useEffect(
        function () {
            async function fetchCourses() {
                try {
                    axios
                        .get(`/sessions/${id}`, {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then((res) => setCourseData(res.data.data));
                    setIsLoading(false);
                } catch (error) {
                    setError(error);
                }
            }
            fetchCourses();
        },
        [id]
    );
    return (
        <div>
            {error && <p>{error}</p>}
            {isLoading && <Loader />}
            {courseData && (
                <div>
                    <h2 className="text-base font-semibold leading-7 text-gray-900">
                        Edit {courseData.name}
                    </h2>
                    <EditForm
                        course={courseData}
                        handleChange={setCourseData}
                    />
                </div>
            )}
        </div>
    );
}

export default Session;
