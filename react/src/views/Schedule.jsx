import useDataFetching from "../hooks/useDataFetching";
import ScheduleAccordion from "../components/global/ScheduleAccordion";
import Table from "../components/global/Table";
import Loader from "../components/global/Loader";
import Header from "../components/global/Header";
import CreateEntityModal from "../components/global/CreateEntityModal";

function Schedule() {
    const { data, error, loading } = useDataFetching("/schedule");

    const fields = [
        {
            name: "session_id",
            label: "Session Name",
            type: "select",
            options: [],
        },
        {
            name: "date",
            type: "date",
            label: "Date",
        },
        {
            name: "zoom_room_id",
            type: "select",
            options: [],
            label: "Zoom Room",
        },
        {
            name: "trainer_id",
            type: "select",
            options: [],
            label: "Trainer",
        },
    ];

    return error ? (
        <p>{error}</p>
    ) : loading ? (
        <Loader />
    ) : (
        <>
            <Header title="Schedule" />
            {data.map((item) => (
                <ScheduleAccordion
                    key={item.id}
                    course={item.course_name}
                    cohort={item.cohort_name}
                >
                    <Table data={item.sessions} key={item.cohort_name} />
                </ScheduleAccordion>
            ))}
        </>
    );
}

export default Schedule;
