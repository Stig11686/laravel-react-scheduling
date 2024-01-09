import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import Table from "../components/global/Table";
import Loader from "../components/global/Loader";
import axios from "../../axios";
import RegisterOverview from "./RegisterOverview";

function Cohort() {
    const [courseData, setCourseData] = useState(null);
    const [error, setError] = useState("");
    const [isLoading, setIsLoading] = useState(true);

    const { id } = useParams();

    useEffect(
        function () {
            async function fetchCourses() {
                setIsLoading(true);
                try {
                    axios
                        .get(`/cohorts/${id}`, {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then((res) => setCourseData(res.data.data));
                } catch (error) {
                    
                    setError(error);
                } finally {
                    setIsLoading(false);

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
                <>
                    <div>
                        <h2 className="text-base font-semibold leading-7 text-gray-900">
                            {courseData.name} Details
                        </h2>
                    </div>
                    <div>
                        <h3>Details</h3>
                    </div>
                    <div>
                        <h3>Learners</h3>
                        <Table data={courseData.learners} />
                    </div>
                    <RegisterOverview id={id} loading={isLoading} attendanceData={courseData.allAttendance} />
                </>
            )}
        </div>
    );
}

export default Cohort;
