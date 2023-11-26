import DataFetchingComponent from "../components/global/DataFetchingComponent";

function Tasks() {
    const fields = [
        {
            name: "name",
            type: "text",
            label: "Name",
        },
        {
            name: "description",
            type: "text",
            label: "Task Description",
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
    ];
    return (
        <DataFetchingComponent
            endpoint="/tasks"
            title="Tasks"
            createEntityFields={fields}
        />
    );
}

export default Tasks;
