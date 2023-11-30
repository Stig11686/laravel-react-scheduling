import DataFetchingComponent from "../components/global/DataFetchingComponent";
import useDataFetching from "../hooks/useDataFetching";

function Cohorts() {
    const { data } = useDataFetching("/courses");
    const fields = [
        {
            name: "name",
            type: "text",
            label: "Cohort Name",
        },
        {
            name: "course_id",
            type: "select",
            label: "Course",
            options: data.map((course) => ({
                value: course.id,
                label: course.name,
            })),
        },
        {
            name: "start_date",
            type: "date",
            label: "Start Date",
        },
        {
            name: "end_date",
            type: "date",
            label: "End Date",
        },
        {
            name: "places",
            type: "text",
            label: "Places Available",
        },
    ];
    return (
        <DataFetchingComponent
            endpoint="/cohorts"
            title="Cohorts"
            createEntityFields={fields}
        />
    );
}

export default Cohorts;
