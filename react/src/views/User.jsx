import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import Table from "../components/global/Table";
import Loader from "../components/global/Loader";
import axios from "../../axios";

function User() {
    const [userData, setUserData] = useState(null);
    const [error, setError] = useState("");
    const [isLoading, setIsLoading] = useState(true);

    const { id } = useParams();

    useEffect(
        function () {
            async function fetchUser() {
                try {
                    axios
                        .get(`/users/${id}`, {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then((res) => setUserData(res.data.data));
                    setIsLoading(false);
                } catch (error) {
                    setError(error);
                }
            }
            fetchUser();
        },
        [id]
    );

    return (
        <div>
            {error && <p>{error}</p>}
            {isLoading && <Loader />}
            {userData && (
                <>
                    <div>
                        <h2 className="text-base font-semibold leading-7 text-gray-900">
                            {userData.name} Details
                        </h2>
                    </div>
                    <div>
                        <h3>Details</h3>
                    </div>
                    <div>
                        <h3>User</h3>
                        {/* <Table data={courseData.learners} /> */}
                    </div>
                </>
            )}
        </div>
    );
}

export default User;
