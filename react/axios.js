import Axios from "axios";

const axios = Axios.create({
    baseURL: `${import.meta.env.VITE_BASE_URL}/api`,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

axios.interceptors.request.use((config) => {
    const token = localStorage.getItem("ACCESS_TOKEN");

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

axios.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        const { response } = error;
        if (response.status === 401) {
            localStorage.removeItem("ACCESS_TOKEN");
        }

        throw error;
    }
);

export default axios;
