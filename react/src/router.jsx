import { createBrowserRouter, Navigate } from "react-router-dom";
import DefaultLayout from "./components/DefaultLayout";
import GuestLayout from "./components/GuestLayout";
import Login from "./views/Login";
import Courses from "./views/Courses";
import Course from "./views/Course";
import Cohorts from "./views/Cohorts";
import Cohort from "./views/Cohort";
import Sessions from "./views/Sessions";
import Session from "./views/Session";
import Schedule from "./views/Schedule";
import Dashboard from "./views/Dashboard";
import NotFound from "./views/404";
import Tasks from "./views/Tasks";
import Task from "./views/Task";

const router = createBrowserRouter([
    {
        path: "/",
        element: <DefaultLayout />,
        children: [
            {
                path: "/",
                element: <Navigate to={"/dashboard"} />,
            },
            {
                path: "/dashboard",
                element: <Dashboard />,
            },
            {
                path: "/courses",
                element: <Courses />,
            },
            {
                path: "/courses/:id",
                element: <Course />,
            },
            {
                path: "/cohorts",
                element: <Cohorts />,
            },
            {
                path: "/cohorts/:id",
                element: <Cohort />,
            },
            {
                path: "/tasks",
                element: <Tasks />,
            },
            {
                path: "/tasks:id",
                element: <Task />,
            },
            {
                path: "/sessions",
                element: <Sessions />,
            },
            {
                path: "/sessions:id",
                element: <Session />,
            },
            {
                path: "/schedule",
                element: <Schedule />,
            },
        ],
    },
    {
        path: "/",
        element: <GuestLayout />,
        children: [
            {
                path: "/login",
                element: <Login />,
            },
        ],
    },
    {
        path: "*",
        element: <NotFound />,
    },
]);

export default router;
