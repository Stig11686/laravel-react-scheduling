import Loader from "../components/global/Loader";




const RegisterOverview = ({ attendanceData }) => {
 
  if (!attendanceData) {
    return <p>Loading...</p>;
  }

  const formatDate = (date) => {

    const [year, month, day] = date.split("-");
    const parsedDate = new Date(
      parseInt(year, 10),
      parseInt(month, 10) - 1,
      parseInt(day, 10)
  );
    if (!isNaN(parsedDate.getTime())) {
      // Format date as d-m-Y
      const options = {
          day: "numeric",
          month: "numeric",
          year: "numeric",
      };
      return parsedDate.toLocaleDateString(undefined, options);
  }
  
    return date;
  }

const learners = Object.keys(attendanceData);

// Extract session IDs from the first learner (assuming all learners have the same sessions)
const sessions = Object.keys(attendanceData[learners[0]]);

return (
  <>
    <div className="py-12">
      <h2 className="text-3xl mb-8">Register Overview</h2>
      <div className="overflow-x-auto">
        <table className="min-w-full text-center table-auto">
            <thead>
                <tr>
                    <th>Learner/Session</th>
                    {/* Render session headers */}
                    {sessions.map(sessionId => (
                        <th key={sessionId}><span className="font-light transform -rotate-90 px-2">{sessionId}</span></th>
                    ))}
                </tr>
                <tr>
                  <th></th>
                  {sessions.map(sessionId => (
                        <th key={sessionId}><span className="transform -rotate-90 px-2">{formatDate(attendanceData[learners[0]][sessionId].session_date)}</span></th>
                    ))}
                </tr>
            </thead>
            <tbody>
                {/* Loop through learners to render rows */}
                {learners.map(learnerId => (
                    <tr key={learnerId}>
                        <td className="whitespace-nowrap py-2">{learnerId}</td>
                        {/* Loop through sessions to render attendance status */}
                        {sessions.map(sessionId => {
                          const status = attendanceData[learnerId][sessionId].status;
                            return (<td key={`${learnerId}-${sessionId}`} className={status === 'P' ? 'bg-green-200' : status === 'A'? 'bg-red-200' :''}>
                                {status}
                            </td>
                        )})}
                    </tr>
                ))}
            </tbody>
        </table>
      </div>
    </div>
  </>
  
    
);
};

export default RegisterOverview;
