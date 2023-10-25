import DataFetchingComponent from "../components/global/DataFetchingComponent";

function Courses() {
    const fields = [{ name: "name", type: "text", label: "Title" }];
    return (
        <DataFetchingComponent
            endpoint="/courses"
            title="Courses"
            createEntityFields={fields}
        />
    );
}
export default Courses;
