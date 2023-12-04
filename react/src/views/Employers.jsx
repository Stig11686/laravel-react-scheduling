import DataFetchingComponent from "../components/global/DataFetchingComponent";

function Employers() {
    const fields = [{ name: "name", type: "text", label: "Title" }];
    return (
        <DataFetchingComponent
            endpoint="/employers"
            title="Employers"
            createEntityFields={fields}
        />
    );
}
export default Employers;
