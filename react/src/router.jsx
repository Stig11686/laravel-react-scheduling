import { createBrowserRouter, Navigate } from "react-router-dom";
import DefaultLayout from "./components/DefaultLayout";
import GuestLayout from "./components/GuestLayout";
import Login from "./views/Login";
import Courses from "./views/Courses";
import Course from "./views/Course";
import Employers from "./views/Employers";
import Employer from "./views/Employer";
import Cohorts from "./views/Cohorts";
import Cohort from "./views/Cohort";
import Sessions from "./views/Sessions";
import Session from "./views/Session";
import Schedule from "./views/Schedule";
import CohortSchedule from "./views/CohortSchedule";
import Dashboard from "./views/Dashboard";
import NotFound from "./views/404";
import Tasks from "./views/Tasks";
import Task from "./views/Task";
import Users from "./views/Users";
import User from "./views/User";

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
                path: "/sessions/:id",
                element: <Session />,
            },
            {
                path: "/schedule",
                element: <Schedule />,
            },
            {
                path: "/schedule/:id",
                element: <CohortSchedule />,
            },
            {
                path: "/users",
                element: <Users />,
            },
            {
                path: "/users/:id",
                element: <User />,
            },
            {
                path: "/employers",
                element: <Employers />,
            },
            {
                path: "/employers/:id",
                element: <Employer />,
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
