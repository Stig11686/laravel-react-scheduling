import { Navigate, Outlet } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";

function GuestLayout() {
    const { token } = useStateContext();

    if (token) {
        return <Navigate to={"/"} />;
    }

    return (
        <div className="h-full max-w-3xl mx-auto">
            <Outlet />
        </div>
    );
}

export default GuestLayout;
