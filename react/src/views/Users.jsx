import DataFetchingComponent from "../components/global/DataFetchingComponent";
import useDataFetching from "../hooks/useDataFetching";

function Users() {
    const { data } = useDataFetching("/users");
    const fields = [
        {
            name: "name",
            type: "text",
            label: "User Name",
        },
    ];
    return (
        <DataFetchingComponent
            endpoint="/users"
            title="Users"
            createEntityFields={fields}
        />
    );
}

export default Users;
