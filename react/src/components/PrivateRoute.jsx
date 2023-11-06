import { Route, Navigate } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider"; // Import your context provider

const PrivateRoute = ({ element: Element, roles, permissions, ...rest }) => {
    const { userRoles, userPermissions } = useStateContext();

    // Check if the user has the required roles and permissions to access the route
    const isAuthorized =
        userRoles.some((role) => roles.includes(role)) &&
        userPermissions.some((permission) => permissions.includes(permission));

    return (
        <Route
            {...rest}
            element={
                isAuthorized ? <Element /> : <Navigate to="/unauthorized" />
            }
        />
    );
};

export default PrivateRoute;
