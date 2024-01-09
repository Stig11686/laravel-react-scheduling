import Loader from "../components/global/Loader";
import { useState } from "react";
import axios from "../../axios";


const RegisterOverview = ({ id, attendanceData }) => {
  const [editedData, setEditedData] = useState(attendanceData);
  const [pendingUpdates, setPendingUpdates] = useState([]);
  const [isLoading, setIsLoading] = useState(false);

  const updateAttendance = (learnerId, sessionId, learnerid, sessionid, status) => {
    const updatedData = {
      learner_id: learnerid,
      session_id: sessionid,
      status
    };

    const displayData = { ...editedData };
    displayData[learnerId][sessionId].status = status;

    setEditedData(displayData);
    setPendingUpdates([...pendingUpdates, updatedData]);
  };

  const sendUpdatesToServer = () => {
    setIsLoading(true);
    axios
      .post(`/cohorts/${id}/attendance`, { pendingUpdates, cohort_id: id })
      .then(response => {
        setPendingUpdates([]); // Clear pendingUpdates after successful update
      })
      .catch(error => {
        console.error('Error sending updates:', error);
        // Handle error scenarios here
      }).finally(() => {
        setIsLoading(false);
      });
  };

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

const sessions = Object.keys(attendanceData[learners[0]]);

const statusOptions = ['P', 'A', 'L',];   


  return (
    <>
      <div className="py-12">
        <h2 className="text-3xl mb-8">Register Overview</h2>
        <div className="overflow-x-auto">
          <table className="min-w-full text-center table-auto border-collapse">
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
              {learners.map(learnerId => (
                  <tr key={learnerId}>
                      <td className="whitespace-nowrap py-2">{learnerId}</td>
                      {sessions.map(sessionId => (
                          <td key={`${learnerId}-${sessionId}`} className="cursor-pointer p-0">
                              <select
                                  className={`
                                  ${editedData[learnerId][sessionId].status === 'P' ? 'bg-green-200' :
                                      editedData[learnerId][sessionId].status === 'A' ? 'bg-red-200' : 'bg-gray-200'}
                                    w-full border-0`}
                                  value={editedData[learnerId][sessionId].status || ''}
                                  onChange={(e) => updateAttendance(learnerId, sessionId, editedData[learnerId][sessionId].learner_id, editedData[learnerId][sessionId].session_id, e.target.value)}
                              >
                                  <option value="" disabled hidden></option>

                                  {statusOptions.map((option) => (
                                      <option className="w-full text" key={option} value={option}>
                                          {option}
                                      </option>
                                  ))}
                              </select>
                          </td>
                      ))}
                  </tr>
              ))}
          </tbody>
          </table>
        </div>
        <button
            disabled={pendingUpdates.length === 0}
            onClick={() => sendUpdatesToServer()}
            className="bg-blue-500 text-white px-4 py-2 mt-4 disabled:bg-gray-200"
          >
            {isLoading ? <Loader /> : 'Save Register'}
          </button>
      </div>
    </>
  );
};

export default RegisterOverview;

  
