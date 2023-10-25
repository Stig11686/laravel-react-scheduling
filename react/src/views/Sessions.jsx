import DataFetchingComponent from "../components/global/DataFetchingComponent";

function Sessions() {
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
