import DataFetchingComponent from "../components/global/DataFetchingComponent";
import useDataFetching from "../hooks/useDataFetching";

function Sessions() {
    const { data } = useDataFetching("/tasks");

    const fields = [
        {
            name: "name",
            type: "text",
            label: "Name",
        },
        {
            name: "review_due",
            type: "date",
            label: "Review Due",
        },
        {
            name: "review_status",
            type: "select",
            options: [
                {
                    label: "Complete",
                    value: "complete",
                },
                {
                    label: "Awaiting Review",
                    value: "awaiting_review",
                },
            ],
            label: "Review Status",
        },
        {
            name: "slides",
            type: "text",
            label: "Slides Link",
        },
        {
            name: "trainer_notes",
            type: "text",
            label: "Trainer Notes",
        },
        {
            name: "array_selected_id",
            type: "select",
            label: "Press Ctrl + Click to Add/Remove tasks!",
            multiple: true,
            options: data.map((task) => ({
                value: task.id,
                label: task.name,
                //     selected: selectedIds.includes(task.id),
            })),
        },
    ];
    return (
        <DataFetchingComponent
            endpoint="/sessions"
            title="Sessions"
            createEntityFields={fields}
        />
    );
}

export default Sessions;
