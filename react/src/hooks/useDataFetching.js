import { useState, useEffect } from "react";
import axios from "../../axios";

function useDataFetching(endpoint, page = 1) {
    const [data, setData] = useState([]);
    const [pagination, setPagination] = useState(null);
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        async function fetchData() {
            setLoading(true);
            try {
                const response = await axios.get(endpoint, {
                    params: {
                        page: page,
                    },
                    headers: {
                        "Content-Type": "application/json",
                    },
                });
                setData(response.data.data);
                setPagination(response.data.pagination || null);
                setLoading(false);
            } catch (error) {
                setError(error);
                setLoading(false);
            }
        }
        fetchData();
    }, [endpoint, page]);

    return { data, setData, error, loading, pagination };
}

export default useDataFetching;
